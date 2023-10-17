<template>
    <div class="notification alert"
         :class="{'alert-success': isSuccess, 'alert-danger': !isSuccess}"
         role="alert">
        {{ message }}
    </div>
</template>

<script>
export default {
    props: {
        isSuccess: {
            type: Boolean,
            required: true
        },
        message: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>
.notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 15px;
    border-radius: 4px;
    margin-right: 15px;
    font-weight: bold;
    z-index: 9999;
}

.notification.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.notification.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
</style>
