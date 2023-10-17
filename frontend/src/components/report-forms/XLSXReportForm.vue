<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Вивантажити дані з усіх станцій</h4>
                <form @submit.prevent="fetchFirstTypeReport()">
                    <div class="form-row">
                        <div class="form-group col-md-5 mb-2">
                            <label class="" for="meeting-time">Початок: </label>
                            <input type="datetime-local" id="meeting-time" class="form-control"
                                   name="meeting-time" value=""
                                   :min="firstVaisalaSplitTime"
                                   :max="lastVaisalaSplitTime"
                                   v-model="form.timeStart">
                            <p class="text-danger" id="time-start">{{
                                    alertTimeStart
                                }}
                            </p>

                        </div>
                        <div class="form-group col-md-5 mb-2">
                            <label class="" for="meeting-time">Кінець: </label>
                            <input type="datetime-local" id="meeting-time" class="form-control"
                                   name="meeting-time" value=""
                                   :min="firstVaisalaSplitTime"
                                   :max="lastVaisalaSplitTime"
                                   v-model="form.timeEnd">
                            <p v-if="alertTimeEnd" class="text-danger" id="time-end">Set heights using classes like
                            </p>
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
    name: 'XLSXReportForm',
    data() {
        return {
            form,
            lineData: [],
            chartsData: [],
            alertTimeStart: '',
            alertTimeEnd: false,
            lastVaisalaSplitTime: '',
            firstVaisalaSplitTime: '',
            chartRows: this.appConfig.chartRows,
            selectedValue: '',
        }
    },
    async mounted() {
        await this.getVaisalaRange()
    },

    methods: {
        async getVaisalaRange() {
            const splitRangeResponse = await axios.get('/api/vaisala/range/stations');

            this.lastVaisalaSplitTime = this.toDate(splitRangeResponse.data.data.last);
            this.firstVaisalaSplitTime = this.toDate(splitRangeResponse.data.data.first);

            this.form.timeEnd = this.lastVaisalaSplitTime

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

        toFileDate(date) {
            let now = date;
            if (!(date instanceof Date)) {
                now = new Date(date);
            }

            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        /**
         * Handles date interval and makes an API request to get report.
         *
         * @async
         * @function
         */
        async  fetchFirstTypeReport() {
            if (!this.validate(this.form.timeStart, this.form.timeEnd)) {
                this.alertTimeStart = 'Інтервал має бути у проміжку від 20 хвилин до 24 годин';
                return;
            }

            try {
                const response =  await axios.get(`/api/report/xlsx?dateFrom=${this.form.timeStart}&dateTo=${this.form.timeEnd}`, { responseType: 'blob' });

                if (response.status === 200) {
                    // const contentType = response.headers['content-type'];
                    //contentType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                        console.log(response.headers['content-type']);
                        const url = window.URL.createObjectURL(new Blob([response.data]));

                        const link = document.createElement('a');
                        link.href = url;
                        link.download = this.toFileDate(this.form.timeStart) + ' - ' + this.toFileDate(this.form.timeEnd) +'.xlsx';
                        link.style.display = 'none';

                        document.body.appendChild(link);
                        link.click();

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
            const diffInMinutes = diffInMilliseconds / (1000 * 60) ;
            const diffInHours = diffInMilliseconds / (1000 * 60 * 60);
            return  diffInHours <= 24 && diffInMinutes >= 20;
        },
    }

}
</script>
<style scoped>

</style>
