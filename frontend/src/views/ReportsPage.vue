<template>
    <div class="content-body">
        <FirstTypeReportForm/>
        <XLSXReportForm/>
    </div>
</template>


<script>
import FirstTypeReportForm from "@/components/report-forms/FirstTypeReportForm.vue";
import XLSXReportForm from "@/components/report-forms/XLSXReportForm.vue";

export default {
    name: 'Charts20mGroup',
    components: {XLSXReportForm, FirstTypeReportForm},
}
</script>
<style scoped>

</style>

