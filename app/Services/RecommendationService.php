<?php

namespace App\Services;

use App\Models\product_reviews;
use App\Models\orders;
use App\Models\Product;

class RecommendationService
{
    private $matrix = [];
    private $similarities = [];
    private $products;
    
    // 1. SINKRONISASI: Ubah threshold ke 0 agar selaras dengan Admin Filament
    private const SIMILARITY_THRESHOLD = 0;

    public function __construct()
    {
        $this->products = Product::all();
        $this->matrix = $this->buildMatrix();
        $this->similarities = $this->buildSimilarityTable();
    }

    private function buildMatrix()
    {
        $matrix = [];

        $orders = orders::where('orderStatus', 'completed')
            ->with('items.product')
            ->get();

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                if (!$item->product) continue;
                $userId = $order->userId;
                $productCode = $item->product->productCode;
                if (!isset($matrix[$userId][$productCode])) {
                    $matrix[$userId][$productCode] = 0;
                }
                $matrix[$userId][$productCode] += $item->qty;
            }
        }

        foreach ($matrix as $userId => $products) {
            foreach ($products as $productCode => $qty) {
                if ($qty >= 3) $matrix[$userId][$productCode] = 5;
                elseif ($qty == 2) $matrix[$userId][$productCode] = 4;
                else $matrix[$userId][$productCode] = 3;
            }
        }

        return $matrix;
    }

    private function getUserAverageRating($userId)
    {
        if (!isset($this->matrix[$userId])) {
            return 0;
        }

        return array_sum($this->matrix[$userId]) / count($this->matrix[$userId]);
    }

    private function cosineSimilarity($ratingsA, $ratingsB)
    {
        $commonUsers = array_intersect(
            array_keys($ratingsA),
            array_keys($ratingsB)
        );

        if (count($commonUsers) < 2) {
            return 0;
        }

        $numerator = 0;
        $denominatorA = 0;
        $denominatorB = 0;

        foreach ($commonUsers as $userId) {
            $userAvg = $this->getUserAverageRating($userId);

            $adjustedA = $ratingsA[$userId] - $userAvg;
            $adjustedB = $ratingsB[$userId] - $userAvg;

            $numerator += $adjustedA * $adjustedB;

            $denominatorA += pow($adjustedA, 2);
            $denominatorB += pow($adjustedB, 2);
        }

        $denominator = sqrt($denominatorA) * sqrt($denominatorB);

        return $denominator > 0
            ? round($numerator / $denominator, 4)
            : 0;
    }

    private function buildSimilarityTable()
    {
        $similarities = [];
        $productCodes = $this->products->pluck('productCode')->toArray();

        foreach ($productCodes as $productA) {
            foreach ($productCodes as $productB) {
                if ($productA == $productB) {
                    $similarities[$productA][$productB] = 1.0;
                } else {
                    $ratingsA = [];
                    $ratingsB = [];

                    foreach ($this->matrix as $userId => $products) {
                        if (isset($products[$productA])) {
                            $ratingsA[$userId] = $products[$productA];
                        }
                        if (isset($products[$productB])) {
                            $ratingsB[$userId] = $products[$productB];
                        }
                    }

                    $similarities[$productA][$productB] = $this->cosineSimilarity($ratingsA, $ratingsB);
                }
            }
        }

        return $similarities;
    }

    public function getRecommendations($userId, $topN = 10)
    {
        if (!isset($this->matrix[$userId])) {
            return collect();
        }

        $ratedProducts = $this->matrix[$userId];
        $productCodes = $this->products->pluck('productCode')->toArray();
        $predictions = [];

        foreach ($productCodes as $productCode) {
            if (isset($ratedProducts[$productCode])) continue;

            $numerator = 0;
            $denominator = 0;

            foreach ($ratedProducts as $ratedCode => $rating) {
                $sim = $this->similarities[$productCode][$ratedCode] ?? 0;
                if ($sim < self::SIMILARITY_THRESHOLD) {
                    continue;
                }
                $numerator += $sim * $rating;
                $denominator += abs($sim);
            }

            // 2. SINKRONISASI: Tambahkan logika else (Fallback ke User Average) agar nilai selaras dengan Admin
            if ($denominator > 0) {
                $score = $numerator / $denominator;
                $predictions[$productCode] = round(min(5, max(1, $score)), 4);
            } else {
                $userAvg = $this->getUserAverageRating($userId);
                $predictions[$productCode] = round($userAvg, 4);
            }
        }

        arsort($predictions);
        
       $topCodes = array_slice(array_keys($predictions), 0, 3);

        return Product::whereIn('productCode', $topCodes)
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->get()
        ->sortBy(function ($product) use ($topCodes) {
            return array_search($product->productCode, $topCodes);
        })
        ->values();

        // Mengembalikan data produk yang sudah diurutkan berdasarkan skor tertinggi
        return Product::whereIn('productCode', $topCodes)
            ->get()
            ->sortBy(function ($product) use ($topCodes) {
                return array_search($product->productCode, $topCodes);
            })
            ->values();
    }
}