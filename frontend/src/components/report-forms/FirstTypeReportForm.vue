<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Завантажити звіт Перетин підприємств північного промвузла</h4>
                <form @submit.prevent="fetchFirstTypeReport()">
                    <div class="col-lg-6 first-type-report-picker">
                        <label class="" for="meeting-time">Станція: </label>
                        <select
                            class="form-control "
                            id="val-skill"
                            name="val-skill"
                            v-model="selectedSensor"
                            @change="getVaisalaStationRange()"
                        >
                            <option value="T3950713">T3950713</option>
                            <option value="T3950716">T3950716</option>
                            <option value="V0440346">V0440346</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5 mb-2">
                            <label class="" for="meeting-time">Початок: </label>
                            <input type="datetime-local" id="meeting-time" class="form-control"
                                   name="meeting-time" value=""
                                   :min="firstStationSplitTime"
                                   :max="lastStationSplitTime"
                                   v-model="form.timeStart">
                            <p class="text-danger" id="time-start">{{
                                    alertTimeStart
                                }}
                            </p>

                        </div>
                        <div class="form-group col-md-5 mb-2">
                            <label class="" for="meeting-time">Період: </label>
                            <select
                                style="height: 45px;"
                                class="form-control "
                                id="val-skill"
                                name="val-skill"
                                v-model="selectedTime"
                            >
                                <option value="20m">20 хвилин</option>
                                <option value="hour">Година</option>
                                <option value="day">День</option>
                                <option value="week">Неділя</option>
                                <option value="month">Місяць</option>
                                <option value="year">Рік</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="" for="">&nbsp;</label>
                            <button type="submit" class="btn btn-dark mb-2 d-block">Завантажити</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Raphael from 'raphael/raphael'
import axios from "axios";
import {ref} from "vue";

global.Raphael = Raphael

const form = ref({
    timeStart: "",
    timeEnd: "",
})

export default {
    name: 'FirstTypeReportForm',
    data() {
        return {
            form,
            lineData: [],
            chartsData: [],
            alertTimeStart: '',
            alertTimeEnd: false,
            lastStationSplitTime: '',
            firstStationSplitTime: '',
            chartRows: this.appConfig.chartRows,
            selectedSensor: 'T3950713',
            selectedTime: '20m',
        }
    },
    mounted() {
        this.getVaisalaStationRange();
    },
    methods: {
        async getVaisalaStationRange() {
            const splitRangeResponse = await axios.get(`/api/vaisala/range?sensor=${this.selectedSensor}`);

            this.lastStationSplitTime = this.toDate(splitRangeResponse.data.data.last);
            this.firstStationSplitTime = this.toDate(splitRangeResponse.data.data.first);

            this.form.timeEnd = this.lastStationSplitTime

            this.form.timeStart = new Date(new Date(splitRangeResponse.data.data.last).getTime() - (20 * 60 * 1000))
            this.form.timeStart = this.toDate(this.form.timeStart)
        },

        /**
         * Converts a date object to a string in the format "YYYY-MM-DDTHH:MM".
         *
         * @param {Date|string} date - A date object or a date string.
         * @returns {string} The date in the "YYYY-MM-DDTHH:MM" format.
         */
        toDate(date) {
            let now = date;
            if (!(date instanceof Date)) {
                now = new Date(date);
            }

            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        },

        /**
         * Handles date interval and makes an API request to get report.
         *
         * @async
         * @function
         */
        async  fetchFirstTypeReport() {
            // if (!this.validate(this.form.timeStart, this.form.timeEnd)) {
            //     this.alertTimeStart = 'The minimum time interval must be 20 minutes';
            //     return;
            // }

            try {
                const response =  await axios.get(`/api/report/first-type?dateFrom=${this.form.timeStart}&period=${this.selectedTime}&sensor=${this.selectedSensor}`, { responseType: 'blob' });

                if (response.status === 200) {
                    const contentType = response.headers['content-type'];
                    if (contentType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        console.log(response.headers['content-type']);
                        const url = window.URL.createObjectURL(new Blob([response.data]));

                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'Перетин-підприемств-північного-промвузла.docx.docx';
                        link.style.display = 'none';

                        document.body.appendChild(link);
                        link.click();
                    }
                } else {
                    console.error('Server returned an error:', response.statusText);
                }
            } catch (error) {
                console.error(error);
            }
        },

        /**
         * Validates that the time difference between two dates is at least 24 hours.
         *
         * @param {Date|string} timeStart - The start date.
         * @param {Date|string} timeEnd - The end date.
         * @returns {boolean} The validation result.
         */
        validate(timeStart, timeEnd) {
            timeStart = new Date(timeStart);
            timeEnd = new Date(timeEnd);

            const diffInMilliseconds = Math.abs(timeEnd - timeStart);
            const diffInMinutes = diffInMilliseconds / (1000 * 60);
            return diffInMinutes >= 20;
        },
    }

}
</script>
<style scoped>
select{
    height: 10px;
}
.first-type-report-picker{
    padding-left: 0;
    margin-bottom: 5px;
    margin-top: 5px;
}
</style>
