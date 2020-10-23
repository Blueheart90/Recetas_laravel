<template>
    <span v-text="formatearFecha"></span>
</template>

<script>
    export default {
        props: ['fecha','type'],
        mounted() {
            console.log('La fecha es', this.fecha);
        },
        computed: {
            formatearFecha() {
                if (this.type == 'format') {
                    return moment(this.fecha).locale('es').format('DD [de] MMMM [del] YYYY');
                    
                }else{
                    return moment(this.fecha).locale('es').fromNow();;
                }
            }
        },
    }
</script>