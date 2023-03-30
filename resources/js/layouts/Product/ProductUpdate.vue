<template>
    <div>
        <form @submit.prevent="onSubmit" method="POST" @keydown.enter.prevent=''>
            <nav class="navbar fixed-bottom navbar-white bg-white border-top"  style="box-shadow: 0px 0px 1px #888;">
                <div class="container-fluid">
                    <div class="ms-auto">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <button class="btn btn-primary btn-lg rounded-0 px-4 me-5" type="submit" :disabled="isLoading">
                                    <svg class="me-1 mb-1" width="20" height="20">
                                        <use xlink:href="/icons/coreui.svg#cil-save"></use>
                                    </svg>
                                    Save
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row">
                <div class="col-md-8">
                    <div class="bg-white border p-3 mb-4 shadow-sm">
                        <div class="mb-3">
                            <label class="form-label mb-1">Name <span class="text-danger">*</span></label>
                            <input v-model="details.name" type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-1">Slug <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">https://website.com/products/listing/</span>
                                <input v-model="details.slug" type="text" class="form-control" name="slug" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-1">Description</label>
                            <Editor
                                v-model="details.description"
                                server="/api/admin/products/editor/upload"
                            />
                        </div>
                    </div>
                    <div class="bg-white border mb-4 shadow-sm">
                        <h4 class="border-bottom pb-3 p-3">Pricing</h4>
                        <div class="row p-3">
                            <div class="col-md-4">
                                <label class="form-label mb-1">Price <span class="text-danger">*</span></label>
                                <input v-model="details.price" type='number' class="form-control" step="any" placeholder="0.00" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-1">Compare at price</label>
                                <input v-model="details.compare_at_price" type="number" class="form-control" step="any">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-1">quantity</label>
                                <input v-model="details.quantity" type="number" class="form-control">
                            </div>
                        </div>  
                    </div>
                    <div class="bg-white border mb-4 shadow-sm">
                        <div class="border-bottom px-3 py-2 mt-2 d-flex w-100">
                            <h4 class="align-self-center">Media</h4>
                        </div>
                        
                        <div class="p-3">
                            <div class="alert alert-primary" role="alert">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                Note: For best visual appearance, use a product image with a size of 800x800.
                            </div>
                            <div>
                                <Uploader
                                    v-if="hasResponse"
                                    :server="'/api/admin/products/media/add'"
                                    :media="media.saved"
                                    :location="'/storage/products/media'"
                                    @init="initMedia"
                                    @change="changeMedia"
                                    @add="addMedia"
                                    @remove="removeMedia"
                                />
                            </div>
                        </div>  
                    </div>
                    <div class="bg-white border mb-5 shadow-sm">
                        <div class="border-bottom px-3 py-2 mt-2 d-flex w-100">
                            <h4 class="align-self-center">Variants</h4>
                            <div class="align-self-center form-check form-switch form-switch-lg ms-auto">
                                <input v-model="details.has_variants" class="form-check-input mt-0" type="checkbox" role="switch" data-bs-toggle="collapse" data-bs-target="#variants" :aria-expanded="details.has_variants" aria-controls="variants" :checked="details.has_variants ? true : false">
                            </div>
                        </div>
                        <div class="p-3" >
                            <div class="collapse" :class="details.has_variants?'show':''" id="variants"> 
                                <Variants
                                    ref="variants"
                                    v-if="hasResponse"
                                    :media="media.all"
                                    :options-prop="options"
                                    :variants-prop="variants"
                                    @data = 'getData'
                                    @reset = 'reset'
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white border mb-4 shadow-sm">
                        <h4 class="border-bottom pb-3 p-3">Product status</h4>
                        <div class="p-3" >
                            <div @click="details.visibility=!details.visibility" class="p-3 bg-light rounded" :class="details.visibility?'border border-primary border-opacity-75 text-primary':'border border-secondary border-opacity-50'">
                                <div class="form-check">
                                    <input v-model="details.visibility" type="checkbox" class="form-check-input" id="visibility">
                                    <label class="form-check-label" for="visibility">Online store</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border mb-4 shadow-sm">
                        <h4 class="border-bottom pb-3 p-3">Storage details</h4>
                        <div class="p-3" >
                            <input v-model="details.sku" type="text" class="form-control form-control-lg mb-2" placeholder="SKU" style="text-transform:uppercase;" @input="(val) => (details.sku = details.sku.toUpperCase())">
                            <input v-model="details.barcode" type="text" class="form-control form-control-lg mb-2" placeholder="Barcode" style="text-transform:uppercase;" @input="(val) => (details.barcode = details.barcode.toUpperCase())">
                            <input v-model="details.weight" type="number" class="form-control form-control-lg mb-2" placeholder="Weight" step="any">
                        </div>
                    </div>
                    <div class="bg-white border mb-4 shadow-sm">
                        <h4 class="border-bottom pb-3 p-3">Vendor</h4>
                        <div class="p-3" >
                            <input v-model="details.vendor" type="text" class="form-control form-control-lg mb-2" placeholder="Vendor">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <Toast
            ref="toast"
            :type= 'toast.type'
            :message= 'toast.message'
        />
        <Loading
            v-model:active="isLoading"
            :is-full-page="true"
            color="#0d6efd"
            :height=120
            :width=120
        />
    </div>
</template>

<script>
import axios from 'axios'
import Loading from 'vue-loading-overlay';
import Uploader from 'vue-media-upload';

import Editor from '../../components/Product/global/ProductEditor.vue'
import Toast from "../../components/global/Toast.vue";
import Variants from '../../components/Product/Update/VariantsUpdate.vue'

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
                    visibility: false,
                },

                options: [],
                variants: [],

                media: {
                    saved: [],
                    added: [],
                    removed: [],
                    all: [],
                },

                data:{ 
                    options: [],
                    variants: [],
                    media: {},
                    details: {},
                },

                errors: [],
                toast:{
                    type: 'info',
                    message: '',
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
                            this.data=response.data
                            this.details = this.data.details
                            this.options = this.data.options
                            this.media.saved = this.data.media
                            this.variants = this.data.variants
                            this.hasResponse = true
                            this.isLoading = false
                        })
                        .catch(error => {

                        })
                })
            },
            getData(data){
                this.options = data.options
                this.variants = data.variants
            },
            initMedia(media){
                this.media.all = media
            },
            changeMedia(media){
                this.media.all = media
                if(media[0].name){
                    this.details.thumbnail = media[0].name
                }
            },
            addMedia(addedImage, addedMedia){
                this.media.added = addedMedia
            },
            removeMedia(removedImage, removedMedia){
                this.$refs.variants.removeImage(removedImage.name)
                this.media.removed = removedMedia
            },
            onSubmit(){
                this.isLoading=true
                this.setData()
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.put('/api/admin/products/update/' + this.details.id, this.data)
                        .then(response => {
                            window.location.replace('/admin/products')
                        })
                        .catch(error => {
                            this.errors = error.response.data
                            this.toast.type = 'error'
                            this.toast.message = this.errors.message
                            this.$refs.toast.toasty()
                            this.isLoading=false
                        })
                })
            },
            setData(){
                this.data.details = this.details
                this.data.media = this.media
                this.data.options = this.options
                this.data.variants = this.variants
            },
            reset(){
                this.details.reset = true
            },
        },
        computed:{
            
        },
        components:{
            Variants,
            Editor,
            Toast,
            Loading,
            Uploader
        }
    }
</script>

<style scoped>

.form-switch.form-switch-lg .form-check-input {
  height: 2rem;
  width: calc(3rem + 0.75rem);
  border-radius: 4rem;
}

</style>