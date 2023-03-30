<template>
    <div>
        <div v-for="(option, index) in options" class="mb-3 col-6" :key="index">
            <p class="fs-5 fw-bold mb-1">{{ option.name }}</p>
            <select @change="changeOption()" v-model="item.options[index].value" class="form-select form-select-lg">
                <option v-for="(value, vindex) in option.values" :key="vindex">{{ value.name }}</option>
            </select>
        </div>
    </div>
</template>

<script>
import cloneDeep from 'lodash/cloneDeep';

    export default {
        props:{
            options:{
                type: Array,
                default: []
            },
            variants:{
                type: Array,
                default: []
            }
        },
        mounted(){
            this.$emit('init', this.item.variant)
        },
        data(){
            return{
                item:{
                    options: cloneDeep(this.variants[0].options),
                    variant: this.variants[0]
                },
            }
        },
        methods:{
            changeOption(){
                let optionsLength = this.options.length
                loop:
                for(let i=0; i < this.variants.length; i++){
                    for(let j=0; j < optionsLength; j++){
                        if(this.variants[i].options[j].value === this.item.options[j].value){
                            if(j == optionsLength-1){
                                this.item.variant = this.variants[i]
                                break loop
                            }
                        }else{
                            break
                        }
                    }
                }
                this.$emit('change', this.item.variant)
            },
        },
        components:{
            
        },
        emits:[
            'init',
            'change'
        ]
    }
</script>

<style scoped>

</style>