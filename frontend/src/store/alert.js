export default {
    state: {
        alertShow: false,
        alertText: '',
        alertSuccess: false,
    },
    getters: {
        getAlertShow(state){
            return state.alertShow;
        },
        getAlertText(state){
            return state.alertText;
        },
        getAlertSuccess(state){
            return state.alertSuccess;
        },
    },
    actions: {
        updateAlert(ctx, data) {
            this.commit('setAlertShow', data.status);
            this.commit('setAlertText', data.text);
            this.commit('setAlertSuccess', data.success);

            setTimeout(() => {
                this.commit('setAlertShow', false);
                this.commit('setAlertText', '');
                this.commit('setAlertSuccess', false);
            }, 6000);
        }
    },
    mutations: {
        setAlertShow(state, status) {
            state.alertShow = status;
        },
        setAlertText(state, text) {
            state.alertText = text;
        },
        setAlertSuccess(state, status) {
            state.alertSuccess= status;
        },
    }
}




