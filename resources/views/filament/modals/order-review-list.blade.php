<div style="padding:4px;">
    @if ($reviews->isEmpty())
        <div style="text-align:center; padding:32px; color:#9ca3af;">
            <p style="font-size:32px; margin:0;">⭐</p>
            <p style="margin:8px 0 0; font-size:13px;">User belum memberikan review apapun</p>
        </div>
    @else
        <div style="display:flex; flex-direction:column; gap:10px;">
            @foreach ($reviews as $review)
                @php $star = (int) $review->rating; @endphp
                <div style="border:1px solid #e5e7eb; border-radius:12px; padding:14px 16px;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                        <p style="margin:0; font-weight:600; font-size:14px; color:#1f2937;">
                            {{ $review->product->productName ?? $review->productCode }}
                        </p>
                        <span style="font-size:11px; color:#9ca3af; white-space:nowrap;">
                            {{ $review->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <div style="margin-top:6px; display:flex; align-items:center; gap:6px;">
                        <span style="color:#f59e0b; font-size:15px; letter-spacing:1px;">
                            {{ str_repeat('⭐', $star) }}{{ str_repeat('☆', 5 - $star) }}
                        </span>
                        <span style="font-size:11px; color:#6b7280;">({{ $star }}/5)</span>
                    </div>

                    @if (!empty($review->comment))
                        <p style="margin:10px 0 0; font-size:13px; color:#374151; line-height:1.5;">
                            {{ $review->comment }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>