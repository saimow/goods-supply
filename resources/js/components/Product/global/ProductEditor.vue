<template>
    <Editor
        v-model="EditorContent"
        :name="this.name"
        :init="editorConfig"
    />
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
    export default {
        setup(props){
            const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
                var csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', props.server);
                xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhr.setRequestHeader("X-CSRF-Token", csrf_token);
                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };
                xhr.onload = () => {
                    if (xhr.status === 403) {
                        reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                        return;
                    }
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    const json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    resolve(json.location);
                };
                xhr.onerror = () => {
                    reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            });
            const editorConfig = {
                placeholder: "Type something...",
                link_default_protocol: "https",
                menubar: false,
                branding: false,
                convert_urls: false,
                plugins: [
                    'code',
                    'lists',
                    'image',
                    'media',
                    "link",
                    "table",
                    "visualblocks",
                    "visualchars",
                    "fullscreen",
                ],
                toolbar: "undo redo | fontsize blocks | forecolor backcolor removeformat | bold italic underline | alignleft aligncenter alignright alignjustify | image media link table | numlist bullist visualblocks visualchars | fullscreen",
                images_upload_handler: image_upload_handler_callback,
            };
            return {editorConfig}
        },
        mounted(){
            this.EditorContent = this.content
        },
        props:{
            name:{
                type: String,
                default: ''
            },
            content:{
                type: String,
                default: ''
            },
            server:{
                type: String,
                required: true
            },
        },
        data(){
            return{
                EditorContent: '',
            }
        },
        watch: {
            EditorContent(value) {
                this.$emit('input', value);
            }
        },
        components:{
            Editor
        }
    }
</script>

<style scoped>
</style>