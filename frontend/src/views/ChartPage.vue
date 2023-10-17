<template>
    <div class="content-body">
        <charts20m-group/>
        <daily-charts/>
    </div>
</template>

<script>
import Charts20mGroup from "@/components/Charts20mGroup.vue";
import DailyCharts from "@/components/DailyCharts.vue";

export default {
    name: 'ChartPage',
    components: {
        Charts20mGroup,
        DailyCharts,
    },

}
</script>

