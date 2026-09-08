<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :required="$isRequired()" :state-path="$getStatePath()">
    <div
        x-data="{
            state: $wire.entangle('{{ $getStatePath() }}'),
            hover: 0,
            max: {{ $getMaxStars() }},
            labels: {
                1: 'Sangat Buruk',
                2: 'Buruk',
                3: 'Cukup',
                4: 'Baik',
                5: 'Sangat Baik'
            },
            get activeLabel() {
                const value = this.hover || this.state || 0;
                return this.labels[value] ?? 'Pilih rating kamu';
            }
        }"
        style="border:1px solid #f3f4f6; border-radius:14px; padding:20px; background:linear-gradient(180deg, #fffdf7 0%, #ffffff 100%); text-align:center;"
    >
        <div style="display:flex; justify-content:center; gap:6px;">
            <template x-for="i in max" :key="i">
                <button
                    type="button"
                    @click="state = i"
                    @mouseenter="hover = i"
                    @mouseleave="hover = 0"
                    style="background:none; border:none; cursor:pointer; padding:4px; transition:transform 0.15s ease;"
                    :style="(hover === i) ? 'transform:scale(1.2) translateY(-2px);' : 'transform:scale(1);'"
                >
                    <svg
                        width="36" height="36" viewBox="0 0 24 24"
                        :fill="(hover >= i || (!hover && state >= i)) ? '#f59e0b' : '#e5e7eb'"
                        style="transition:fill 0.2s ease; filter:drop-shadow(0 1px 1px rgba(0,0,0,0.06));"
                    >
                        <path d="M12 2l2.9 6.26 6.9.6-5.2 4.53 1.57 6.77L12 16.9l-6.17 3.26 1.57-6.77L2.2 8.86l6.9-.6L12 2z"/>
                    </svg>
                </button>
            </template>
        </div>

        <p
            x-text="activeLabel"
            style="margin-top:10px; font-size:14px; font-weight:600; min-height:20px; transition:color 0.2s ease;"
            :style="state > 0 ? 'color:#f59e0b;' : 'color:#9ca3af;'"
        ></p>

        <div style="display:flex; justify-content:center; gap:4px; margin-top:4px;">
            <template x-for="i in max" :key="'dot-'+i">
                <span
                    style="width:5px; height:5px; border-radius:50%; transition:background 0.2s ease;"
                    :style="(state >= i) ? 'background:#f59e0b;' : 'background:#e5e7eb;'"
                ></span>
            </template>
        </div>
    </div>
</x-dynamic-component>