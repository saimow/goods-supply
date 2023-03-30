<template>
    <div class="slider-container">
        <div class="slider-wrapper">        
            <Splide
                aria-labelledby="thumbnail-example-heading"
                :options="mainOptions"
                ref="main"
            >
                <template v-if="slides.length">
                    <SplideSlide 
                        v-for="(slide, index) in slides"
                        @click="toggleLightbox(index)"
                        class="cursor-pointer"
                    >
                        <img :src="'/storage/products/media/'+slide.name">
                    </SplideSlide>
                </template>
                <template v-else>
                    <SplideSlide 
                        class="cursor-pointer"
                    >
                        <img :src="'/imgs/no-image.png'">
                    </SplideSlide>
                </template>
            </Splide>
        
            <Splide
                ref="thumbs"
                aria-label="The carousel with thumbnails. Selecting a thumbnail will change the main carousel"
                :options="thumbsOptions"
                id="thumbs"
            >
                <template v-if="slides.length">
                    <SplideSlide
                        v-for="slide in slides"
                        class="border border-secondary"
                    >
                        <img :src="'/storage/products/media/'+slide.name">
                    </SplideSlide>
                </template>
                <template v-else>
                    <SplideSlide 
                        class="border border-secondary"
                    >
                        <img :src="'/imgs/no-image.png'">
                    </SplideSlide>
                </template>
            </Splide>
        </div>
    </div>
</template>
  
<script>
    import { Splide, SplideSlide } from '@splidejs/vue-splide';
    import '@splidejs/vue-splide/css';

    export default {
        props:{
            slides: {
                type: Array,
                default: []
            }
        },
        mounted(){
            this.$refs.main.sync( this.$refs.thumbs.splide );
        },
        data(){
            return{
                mainOptions: {
                    type: 'slide',
                    perPage: 1,
                    perMove: 1,
                    gap: '1rem',
                    pagination: false,
                },
                thumbsOptions: {
                    type: 'slide',
                    rewind: true,
                    gap: 5,
                    pagination: false,
                    fixedWidth: 70,
                    fixedHeight: 70,
                    cover: true,
                    focus: 'center',
                    isNavigation: true,
                    updateOnMove: true,
                    arrows: false,
                },
            }
        },
        methods:{
            toggleLightbox(index){
                this.$emit('toggleLightbox', index)
            },
            go(index){
                this.$refs.main.go(index)
            }
        },
        components: {
            Splide,
            SplideSlide
        },
    }
</script>

<style scoped>
.slider-container{
    max-width: 600px
}
.splide__slide img {
    width: 100%;
    height: 600px;
    object-fit: cover;
    
}
.splide--slide {
    margin-top: 0.5rem;
}
#thumbs{
    display: flex;
}
.splide__track--nav>.splide__list>.splide__slide.is-active{
    border: 2px solid #0d6efd !important;
}
.splide__slide>img{
    border-radius: 5px;
}
</style>