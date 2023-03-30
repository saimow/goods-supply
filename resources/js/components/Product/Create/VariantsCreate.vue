<template>
    <div>
        <div class="border d-flex px-4 py-2 ">
            <button  @click="addOption" type="button" class="btn btn-primary btn-lg rounded-0 ms-auto">
                <i class="bi bi-plus-lg"></i> Add Option
            </button>
        </div>
        <div class="border border-top-0 p-3 mb-3">
            <div v-for="(option, index) in options" :key="index" class="border border-secondary border-opacity-50 p-3 bg-light mb-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label mb-1">Option</label>
                        <input v-model="options[index].name" @change="updateOptions(index)" class="form-control" type="text">
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Values</label>
                        <Multiselect
                            class="multiselect-blue"
                            v-model="options[index].values"
                            :options="options[index].values"
                            mode="tags"
                            :caret="false"
                            :show-options="false"
                            :create-option="true"
                            :searchable="true"
                            :can-clear="false"
                            :object="true"
                            valueProp="name"
                            label="name"
                            :disabled="options[index].name ? false : true"
                            @change="setVariants($event, index)"
                        />
                    </div>
                    <div class="col-2 align-self-end">
                        <button @click="deleteOption(index)" class="btn btn-danger ms-auto" type="button">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="border p-3">
            <div v-for="(variant, index) in variants" :key="index">
                <div class="border border-secondary border-opacity-50 p-3 bg-light">
                    <div class="row">
                        <div class="col-xl-3">
                            <div>
                                <p class="fw-bold ms-1">
                                    <template v-for="(option, oindex) in variant.options" :key="oindex">
                                        <template v-if="(oindex != 0)"> / </template>
                                        {{option.value}}
                                    </template>
                                </p>
                            </div>
                            <div>
                                <img class="border border-secondary border-opacity-50 rounded img-fluid variant-image" :src="variant.image ? '/storage/tmp/uploads/'+variant.image : '/imgs/no-image.png'"  data-bs-toggle="modal" :data-bs-target="'#image'+index">
                            </div>
                            <div class="form-check mt-3 ms-2">
                                <input @change="setDefaultVariant(index)" :checked="selected===index" type="checkbox" class="form-check-input" :id="'isDefault'+index">
                                <label class="form-check-label text-primary fw-semibold" :for="'isDefault'+index">Default variant</label>
                            </div>
                        </div>
                        <div class="col-xl-3 mt-4">
                            <div class="mb-4">
                                <label class="form-label mb-1">Price</label>
                                <input v-model="variants[index].price" type="number" class="form-control" step="any">
                            </div>
                            <div>
                                <label class="form-label mb-1">SKU</label>
                                <input v-model="variants[index].sku" type="text" class="form-control" style="text-transform:uppercase;" @input="(val) => (variants[index].sku = variants[index].sku.toUpperCase())">
                            </div>
                        </div>
                        <div class="col-xl-3 mt-4">
                            <div class="mb-4">
                                <label class="form-label mb-1">Compare at price</label>
                                <input v-model="variants[index].compare_at_price" type="number" class="form-control" step="any">
                            </div>
                            <div>
                                <label class="form-label mb-1">Barcode</label>
                                <input v-model="variants[index].barcode" type="text" class="form-control" style="text-transform:uppercase;" @input="(val) => (variants[index].barcode = variants[index].barcode.toUpperCase())">
                            </div>
                        </div>
                        <div class="col-xl-3 mt-4">
                            <div class="mb-4">
                                <label class="form-label mb-1">Quatity</label>
                                <input v-model="variants[index].quantity" type="number" class="form-control">
                            </div>
                            <div>
                                <label class="form-label mb-1">Weight</label>
                                <input v-model="variants[index].weight" type="number" class="form-control" step="any">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" :id="'image'+index" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Select the variant image</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex flex-row">
                                    <div v-for="(image, key) in media" :key="key" class="me-2" :class="image.name == variant.image ? 'border border-primary border-3 rounded-1' : 'border border-secondary-500 border-3 rounded-1'">
                                        <img @click="setSelectedImage(image.name, index, variant.image)" :src="'/storage/tmp/uploads/'+image.name" class="image-listing ">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</template>

<script>
import Multiselect from '@vueform/multiselect'

    export default {
        props:{
            media:{
                type: Array,
                default: null,
            }
        },
        mounted(){
            this.setVariants()
            this.emits()
        }, 
        data(){
            return{
                options: [],
                // options: [
                //     {
                //         name: 'size',
                //         values: [
                //             {name: 'small'},
                //             {name: 'large'},
                //         ],
                //     },
                //     {
                //         name: 'color',
                //         values: [
                //             {name: 'blue',},
                //             {name: 'red'},
                //         ], 
                //     },
                // ],
                variants: [],
                data: [{
                    options : [],
                    variants : [],
                }],
                selected: null,
            }
        },
        methods:{
            addOption(){
                this.options.push({
                    name: '',
                    values: [],
                })
                this.emits()
            },
            deleteOption(index){
                this.options.splice(index, 1)
                this.setVariants()
            },
            setVariants(values, index){
                this.variants = []
                
                let filledOptions = []
                let variantsCount = 0
                let variantsIndex = []
                let vindex = []

                if(values){
                    this.options[index].values = values
                }

                this.options.forEach((option) => {
                    if(option.values.length && option.name){
                        filledOptions.push(option)
                    }
                });

                filledOptions.forEach((option) => {
                    if(option.values.length){
                        variantsIndex.push(option.values.length - 1)
                        variantsCount = 1
                    }
                })
                
                variantsIndex.forEach((num) => {
                    variantsCount = variantsCount * (num + 1)
                    vindex.push(0)
                })

                for(let i=0; i<variantsCount; i++){
                    this.variants.push(
                        {
                            options: [],
                            is_default: false,
                            image: '',
                            price: null,
                            compare_at_price: null,
                            quantity: null,
                            sku: null,
                            barcode: null,
                            weight: null,
                        }
                    )
                }
                
                this.variants.forEach((variant) => {
                    filledOptions.forEach((option, index) => {
                        variant.options.push(
                            {
                                name: option.name, 
                                value: option.values[vindex[index]].name, 
                            }
                        )
                        if(filledOptions.length - 1 === index){
                            if(variantsIndex[index] == vindex[index]){
                                for(let i = filledOptions.length - 2; i >= 0; i--){
                                    if(variantsIndex[i] != vindex[i]){
                                        for(let j = i+1; j <= filledOptions.length-1; j++){
                                            vindex[j]=0 
                                        }
                                        vindex[i]++
                                        break
                                    }
                                }
                            }else{
                                vindex[index]++
                            }
                        }
                    })
                })

                this.selected = null
                this.emits()
            },
            setSelectedImage(image, index, variantImage){ 
                if(variantImage == image){
                    this.variants[index].image = ''
                }else{
                    this.variants[index].image = image
                }
            },
            setDefaultVariant(index){
                if(this.selected != index){
                    this.selected=index
                    this.variants.forEach((variant, vindex) => {
                        if(index == vindex){
                            this.variants[vindex].is_default = true
                        }else{
                            this.variants[vindex].is_default = false
                        }
                    });
                }else{
                    this.selected=null
                    this.variants.forEach((variant, vindex) => {
                        this.variants[vindex].is_default = false
                    });
                }                
            },
            updateOptions(index){
                if(this.variants.length && this.options[index].values.length){
                    this.variants.forEach((variant, vindex) => {
                        this.variants[vindex].options[index].name = this.options[index].name
                    });
                }
            },
            removeImage(image){
                this.variants.forEach((variant, vindex) => {
                    if(variant.image === image){
                        this.variants[vindex].image = ''
                    }
                });
            },
            emits(){
                this.data.options = this.options
                this.data.variants = this.variants
                this.$emit('data', this.data)
            }
            
        },
        components:{
            Multiselect
        }
    }
</script>

<style scoped>
.variant-image{
    height: 160px;
    width: 160px;
    cursor:pointer;
    object-fit: cover;
    object-position: center;
}

.image-listing{
    height: 80px;
    width: 90px;
    object-fit: cover;
    object-position: center;
}

.multiselect-blue {
  --ms-tag-bg: #0d6efd;
  --ms-tag-color: #ffffff;
  --ms-ring-color: #548ee6;
  --ms-ring-width: 1px;

}
</style>