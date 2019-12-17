<template>
    <div>
        <widgets-stock/>
        <in-stock/>
    </div>
</template>

<script>
    import WidgetsStock from './WidgetsStock'
    import InStock from "./table/InStock";

    export default {
        name: 'Stock',
        components: {
            WidgetsStock,
            InStock
        }
    }
</script>
