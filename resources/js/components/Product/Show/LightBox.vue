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
    import FsLightbox from "fslightbox-vue/v3";
    
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