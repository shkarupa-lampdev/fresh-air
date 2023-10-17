<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ this.chartProperties[chartKey].title }}</h4>
<!--            <div v-if="chartData.length !== 0">-->
            <div >
                <LineChart :data="data" :options="options" />
            </div>
        </div>
    </div>
</template>

<script>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
} from 'chart.js'
import { Line as LineChart } from 'vue-chartjs'

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
)
export default {
    name: "MorisChart",
    components: {
        LineChart,
    },
    props: {
        chartData: {},
        chartKey: {},
        // type: {},
    },
    watch: {
        chartData() {
            this.updateLineData();
            this.updateChartData();
            // this.lineColors = this.chartProperties[this.chartKey].colour
        }
    },
    data() {
        return {
            lineData: [],
            chartLabel: [],
            // lineColors: {
            //     type: String,
            //     default: '#FF6384',
            // },
            data: {
                labels: this.chartLabel,
                datasets: [
                    {
                        backgroundColor: '#f87979',
                        data: this.lineData,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            },
            chartProperties: this.appConfig.chartProperties
        }
    },
    methods: {
        updateLineData() {
            this.chartData.forEach((item) => {
                const timestamp = new Date(item.interval_avg_time);
                // const splitTime = timestamp.getTime()

                this.lineData.push(item[this.chartKey]);

                this.chartLabel.push(timestamp + " Повнота данних " + item[this.chartKey + '_ratio']);
            });
            console.log(this.lineData)
            console.log(this.chartLabel)
        },
        updateChartData() {
            this.data.labels = this.chartLabel;
            this.data.datasets[0].data = this.lineData;
            // this.$refs.chart.update(); // Manually update the chart
        }
    }
}
</script>

<style scoped>

</style>
