<template class="">
    <div class="col-12 col-xxl-10 mx-auto">
        <div class="row mb-5">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <Slider 
                    ref="slider"
                    v-if="hasResponse"
                    :slides="media"
                    @toggle-lightbox="toggleLightbox"
                />
                <Lightbox
                    ref="lightbox"
                    v-if="hasResponse"
                    :sources="mediaSources"
                />
            </div>
            <div class="col-lg-6">
                <h1>{{ details.name }}</h1>
                <br>
                <div class="mb-3">
                    <div class="d-flex flex-row" v-if="item.variant.price">
                        <h4 class="me-3 fw-bold text-primary">{{ formatPrice(item.variant.price) }}</h4>
                        <h4 v-if="item.variant.compare_at_price" class="text-decoration-line-through">{{ formatPrice(item.variant.compare_at_price) }}</h4>
                    </div>
                    <div class="d-flex flex-row" v-else>
                        <h4 class="me-3 fw-bold text-primary">{{ formatPrice(details.price) }}</h4>
                        <h4 v-if="details.compare_at_price" class="text-decoration-line-through">{{ formatPrice(details.compare_at_price) }}</h4>
                    </div>
                </div>
    
                <label class="text-muted d-block">Quantity</label>
                <vue-number-input v-model="item.quantity" class="mb-3" :min="1" :max="10" inline center controls></vue-number-input>
    
                <div v-if="hasResponse && details.has_variants">
                    <div v-if="options">
                        <Options 
                            :options = options
                            :variants = variants
                            @init = "optionsInit"
                            @change = "optionsChange"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded">
            <h2 class="mb-3">Description:</h2>
            <div class="description" v-html="details.description">

            </div>
        </div>
    </div>
</template>

<script>
import Slider from '../../components/Product/Show/Slider.vue'
import Lightbox from '../../components/Product/Show/LightBox.vue'
import Options from '../../components/Product/Show/Options.vue'
import VueNumberInput from '@chenfengyuan/vue-number-input';

    export default {
        props:{
            id: {
                type: String,
                default: null
            }
        },
        mounted(){
            this.getResponse()
            
        },
        data(){
            return{
                details: {
                    name: '',
                    slug: '',
                    description: '',
                    thumbnail: '',
                    price: null,
                    compare_at_price: null,
                    quantity: null,
                    sku: null,
                    barcode: null,
                    weight: null,
                    vendor: '',
                    has_variants: false,
                    visibility: false,
                },

                options: [],
                variants: [],

                media:[],
                mediaSources:[],

                data:{},

                item:{
                    quantity: 1,
                    variant: {}
                },

                isLoading: false,
                hasResponse: false
            }
        },
        methods:{
            getResponse(){
                this.isLoading = true
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('/api/products/data/' + this.id)
                        .then(response => {
                            this.data = response.data
                            this.details = this.data.details
                            this.options = this.data.options
                            this.media = this.data.media
                            this.variants = this.data.variants
                            this.setMediaSources()
                            this.hasResponse = true
                            this.isLoading = false
                        })
                        .catch(error => {

                        })
                })
            },
            setMediaSources(){
                this.media.forEach((image) => {
                    this.mediaSources.push('/storage/products/media/'+image.name)
                });
            },
            toggleLightbox(index){
                this.$refs.lightbox.toggle(index)
            },
            optionsInit(variant){
                this.item.variant = variant
            },
            optionsChange(variant){
                this.item.variant = variant
                
                if(variant.image){
                    let index = 0
                    for(let i = 0; i < this.media.length; i++){
                        if(this.media[i].name === variant.image){
                            index = i
                            break
                        }
                    }
    
                    this.$refs.slider.go(index)
                }
            },
            formatPrice(value) {
                if (typeof value !== "number") {
                    return value;
                }
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                });
                return formatter.format(value);
            },
            
        },
        components:{
            Slider,
            Lightbox,
            VueNumberInput,
            Options
        }
    }
</script>

<style scoped>

</style>