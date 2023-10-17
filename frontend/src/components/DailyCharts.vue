<template>
    <div class="content-body">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Денні графіки</h4>
                    <form @submit.prevent="handleDate()">
                        <div class="form-row">
                            <div class="form-group col-md-5 mb-2">
                                <label class="" for="meeting-time">Початок: </label>
                                <input type="date" id="meeting-time" class="form-control"
                                       name="meeting-time" value=""
                                       :min="firstSplit"
                                       :max="lastSplit"
                                       v-model="form.timeStart">
                                <p class="text-danger" id="time-start">{{
                                        alertTimeStart
                                    }}
                                </p>

                            </div>
                            <div class="form-group col-md-5 mb-2">
                                <label class="" for="meeting-time">Кінець: </label>
                                <input type="date" id="meeting-time" class="form-control"
                                       name="meeting-time" value=""
                                       :min="firstSplit"
                                       :max="lastSplit"
                                       v-model="form.timeEnd">
                                <p v-if="alertTimeEnd" class="text-danger" id="time-end">Set heights using classes like
                                </p>
                            </div>
                            <div class="col-auto">
                                <label class="" for="">&nbsp;</label>
                                <button type="submit" class="btn btn-dark mb-2 d-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row" v-for="chartRow in chartRows" :key="chartRow[0].chartKey">
                <div class="col-lg-4" v-for="chart in chartRow" :key="chart.chartKey">
                    <MorisChart
                        :chart-data="chartsData"
                        :chart-key="chart.chartKey"
                        type="daily"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Raphael from 'raphael/raphael'
import axios from "axios";
import {ref} from "vue";
import MorisChart from "@/components/MorisChart.vue";

global.Raphael = Raphael

const form = ref({
    timeStart: "",
    timeEnd: "",
})
export default {
    name: 'DailyCharts',
    data() {
        return {
            form,
            lineData: [],
            chartsData: [],
            alertTimeStart: '',
            alertTimeEnd: false,
            lastSplit: '',
            firstSplit: '',
            chartRows: this.appConfig.chartRows
        }
    },

    components: {
        MorisChart
    },
    async mounted() {
        const splitRangeResponse = await axios.get("/api/range-daily")
        this.lastSplit = this.toDate(splitRangeResponse.data.data.last);
        this.firstSplit = this.toDate(splitRangeResponse.data.data.first);

        this.form.timeEnd = this.lastSplit

        this.form.timeStart = new Date(splitRangeResponse.data.data.last)
        this.form.timeStart.setDate(this.form.timeStart.getDate() - 2)

        this.form.timeStart = this.toDate(this.form.timeStart)


        this.handleDate()
    },

    methods: {

        toDate(date) {
            let now = date;
            if (!(date instanceof Date)) {
                now = new Date(date);
            }

            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        async handleDate() {
            if (!this.validate(this.form.timeStart, this.form.timeEnd)) {
                this.alertTimeStart =  'Мінімальний проміжок часу має бути 1 день';
                return;
            }

            await axios.post("/api/split-daily", {
                timeStart: this.form.timeStart,
                timeEnd: this.form.timeEnd
            }).then(response => {
                this.chartsData = response.data.data.chart;
            })
                .catch(error => {
                    console.error(error);
                });

        },


        validate(timeStart, timeEnd) {
            timeStart = new Date(timeStart)
            timeEnd = new Date(timeEnd)
            const diffInMilliseconds = Math.abs(timeEnd - timeStart);
            const diffInHours = diffInMilliseconds / (1000 * 60 * 60);
            return diffInHours >= 48;

        }
    }

}
</script>
