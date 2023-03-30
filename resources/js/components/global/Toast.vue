<template>
</template>

<script>
    import { useToast } from "vue-toastification"

    export default {
        props: {
            type:{
                type: String,
                default: 'info'
            },
            message:{
                type: String,
                default: 'Toast'
            },
        },
        setup() {
            const toast = useToast();
            return { toast };
        },
        mounted() {

        },
        methods:{
            toasty(){
                setTimeout(() => {
                    this.toast[this.type](this.message,{
                        position: "bottom-right",
                        timeout: 7000,
                        closeOnClick: true,
                        pauseOnFocusLoss: true,
                        pauseOnHover: true,
                        draggable: true,
                        draggablePercent: 0.6,
                        showCloseButtonOnHover: false,
                        hideProgressBar: false,
                        closeButton: "button",
                        icon: true,
                        rtl: false
                    });
                });
            }
        }
    };
</script>