export default {
    chartProperties: {
        temperature: {
            title: 'Температура (°C)',
            label: '°C',
            colour: '#9068be',
        },
        pressure: {
            title: 'Тиск (Pa)',
            label: 'Pa',
            colour: '#173e43',
        },
        humidity: {
            title: 'Вологість',
            label: '%',
            colour: '#9068be',
        },

        dust_PM1: {
            title: 'Рівень пилу pm1',
            label: 'ug/m3',
            colour: '#2effb4',
        },
        dust_PM2_5: {
            title: 'Рівень пилу pm2.5',
            label: 'ug/m3',
            colour: '#2effb4',
        },
        dust_PM10: {
            title: 'Рівень пилу pm10',
            label: 'ug/m3',
            colour: '#2effb4',
        },

        ammonia: {
            title: 'Рівень аміаку nh3 ',
            label: 'ppm',
            colour: '#173e43',
        },
        radiation: {
            title: 'Рівень радіації (uR/h)',
            label: 'uR/h',
            colour: '#6ed3cf',
        },
        chlorine: {
            title: 'Рівень хлору CL2',
            label: 'ppm',
            colour: '#ff8f2e',
        },

        ozone: {
            title: 'Рівень озону О3',
            label: 'ppm',
            colour: '#2e5bff',
        },
        hydrogen_sulfide: {
            title: 'Рівень H2S',
            label: 'ppm',
            colour: '#c22eff',
        },
        sulfur_dioxide: {
            title: 'Рівень SO2',
            label: 'ppm',
            colour: '#ff2ea1',
        },

        carbon_oxide: {
            title: 'Рівень вуглекислого газу CO',
            label: 'ppm',
            colour: '#2e5bff',
        },
        nitrogen_dioxide: {
            title: 'Рівень NO2',
            label: 'ppm',
            colour: '#c22eff',
        },
        max_wind_speed: {
            title: 'Максимальна швидкість вітру',
            label: 'm/s',
            colour: '#ff2ea1',
        },

        rain_intensity: {
            title: 'Інтенсивність дощу',
            label: 'mm/h',
            colour: '#2e5bff',
        },
        rain_accumulation: {
            title: 'Кількість опадів',
            label: 'mm',
            colour: '#c22eff',
        },
        wind_speed: {
            title: 'Швидкість вітру',
            label: 'm/s',
            colour: '#ff2ea1',
        },
    },
    chartRows: [
        [
            {chartKey: 'temperature'},
            {chartKey: 'humidity'},
            {chartKey: 'pressure'},
        ],
        [
            {chartKey: 'dust_PM1'},
            {chartKey: 'dust_PM2_5'},
            {chartKey: 'dust_PM10'},
        ],
        [
            {chartKey: 'ammonia'},
            {chartKey: 'radiation'},
            {chartKey: 'chlorine'},
        ],
        [
            {chartKey: 'ozone'},
            {chartKey: 'hydrogen_sulfide'},
            {chartKey: 'sulfur_dioxide'},
        ],
        [
            {chartKey: 'carbon_oxide'},
            {chartKey: 'nitrogen_dioxide'},
            {chartKey: 'max_wind_speed'},
        ],
        [
            {chartKey: 'rain_intensity'},
            {chartKey: 'rain_accumulation'},
            {chartKey: 'wind_speed'},
        ],
    ],
    backEndUrl: "http://localhost:80",// "https://krnu.lamp-dev.com/"
};
