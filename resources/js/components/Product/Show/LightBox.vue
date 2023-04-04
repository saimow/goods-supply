<template>
    <div>
        <FsLightbox
            :toggler="toggler"
            :sources="sources"
            :sourceIndex="sourceIndex"
        />
    </div>
    </template>
    
    <script>
    import FsLightboxV3 from "fslightbox-vue/v3";
    const FsLightbox = FsLightboxV3.default || FsLightboxV3;
    
    export default {
        props:{
            sources:{
                type: Array,
                default: [],
            }
        },
        data() {
            return {
                toggler: false,
                sourceIndex: 0
            }
        },
        methods:{
            toggle(index){
                this.sourceIndex = index
                this.toggler = !this.toggler
            }
        },
        components: { FsLightbox },
    };
    </script>