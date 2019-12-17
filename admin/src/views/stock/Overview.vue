<template>
    <div>
        <widgets-stock/>
        <widgets-actions/>
        <hr/>
        <in-stock/>
    </div>
</template>

<script>
    import WidgetsStock from './WidgetsStock'
    import InStock from "./table/InStock";
    import WidgetsActions from "./WidgetsActions";

    export default {
        name: 'Stock',
        components: {
            WidgetsStock,
            WidgetsActions,
            InStock
        }
    }
</script>
