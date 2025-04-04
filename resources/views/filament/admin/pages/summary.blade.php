<div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mt-6">
    <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h3 class="font-bold text-gray-800 dark:text-white">📦 Cantidad producida</h3>
        <p>{{ $quantity }} unidades</p>
    </div>

    <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h3 class="font-bold text-gray-800 dark:text-white">📈 Margen de ganancia</h3>
        <p>{{ $margin }} %</p>
    </div>

    <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h3 class="font-bold text-gray-800 dark:text-white">🧪 Total materiales</h3>
        <p>${{ number_format($materials, 2) }}</p>
    </div>

    <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h3 class="font-bold text-gray-800 dark:text-white">🧑‍🌾 Total mano de obra</h3>
        <p>${{ number_format($labor, 2) }}</p>
    </div>

    <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h3 class="font-bold text-gray-800 dark:text-white">🚚 Costos indirectos</h3>
        <p>${{ number_format($indirect, 2) }}</p>
    </div>

    <div class="p-4 bg-green-50 dark:bg-green-800 rounded shadow col-span-full">
        <h3 class="font-bold text-green-700 dark:text-white">💰 Precio de venta unitario sugerido</h3>
        <p class="text-2xl font-semibold text-green-800 dark:text-white">
            ${{ number_format($unitPrice, 2) }}
        </p>
    </div>
</div>
