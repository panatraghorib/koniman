<script setup>
import { computed, shallowRef, ref, onMounted } from "vue";
import { component as CKEditor } from "@ckeditor/ckeditor5-vue";
import Editor from "ckeditor5-custom-build";
import ImageUploadAdapter from "@/CKEditorApi/ImageUploadAdapter.js";
import axios from "axios";

const props = defineProps({
    modelValue: {
        type: [Object, File, Array, String],
        default: null,
    },
    name: {
        type: String,
        default: "",
    },
    error: String,
});

const txtEditor = shallowRef({
    editor: Editor,
    editorConfig: {
        toolbar: {
            items: [
                "sourceEditing",
                "heading",
                "|",
                "bold",
                "italic",
                "underline",
                "link",
                "horizontalLine",
                "bulletedList",
                "numberedList",
                "|",
                "alignment",
                "outdent",
                "indent",
                "fontColor",
                "|",
                "imageInsert",
                "blockQuote",
                "insertTable",
                "mediaEmbed",
                "undo",
                "redo",
                "fontBackgroundColor",
                "showBlocks",
                "removeFormat",
                "fontSize",
                "htmlEmbed",
                "codeBlock",
                "code",
                "findAndReplace",
            ],
        },
        language: "id",
        image: {
            toolbar: [
                "imageTextAlternative",
                "toggleImageCaption",
                "imageStyle:inline",
                "imageStyle:block",
                "imageStyle:side",
                "linkImage",
            ],
        },
        table: {
            contentToolbar: [
                "tableColumn",
                "tableRow",
                "mergeTableCells",
                "tableCellProperties",
            ],
        },
        extraPlugins: [UploadAdapterPlugin, DeleteAdapterPlugin],
    },
});

function UploadAdapterPlugin(editor) {
    editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        //Register Custom Adapter
        // Configure the URL to the upload script in your back-end here!
        return new ImageUploadAdapter(loader);
    };
}

function DeleteAdapterPlugin(editor) {
    // Buat event listener untuk peristiwa penghapusan gambar
    // Event listener untuk perubahan pada dokumen editor
    editor.model.document.on("change:data", (event) => {
        const differ = event.source.differ;
        // if no difference
        if (differ.isEmpty) {
            return;
        }

        const changes = differ.getChanges({
            includeChangesInGraveyard: true,
        });

        if (changes.length === 0) {
            return;
        }

        changes.forEach((change) => {
            const defaultElementTypes = ["image", "imageBlock", "inlineImage"];

            let elementTypes = [...defaultElementTypes];
            // Cek apakah perubahan adalah penghapusan elemen
            if (change.type === "remove" && change.name === "imageBlock") {
                // const imageUrl = change.position.nodeBefore.getAttribute("src");
                const removedNodes = changes.filter(
                    (change) =>
                        change.type === "insert" &&
                        elementTypes.includes(change.name)
                );

                const removedImagesSrc = [];
                // removed image nodes
                const removedImageNodes = [];

                removedNodes.forEach((node) => {
                    const removedNode = node.position.nodeAfter;
                    removedImageNodes.push(removedNode);
                    removedImagesSrc.push(removedNode.getAttribute("src"));
                });

                if (removedImagesSrc) {
                    // Kirim permintaan DELETE ke endpoint di server Laravel untuk menghapus gambar
                    //pada editor
                    axios
                        .post(
                            "/delete-image",
                            { url: removedImagesSrc },
                            {
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            }
                        )
                        .then((response) => {
                            if (response.status == 200) {
                                console.log("--Image deleted.");
                            } else {
                                console.error(
                                    "Failed delete image from server."
                                );
                            }
                        })
                        .catch((error) => {
                            console.error("Terjadi kesalahan:", error);
                        });
                }
                return;
            }
        });
    });
}
const emit = defineEmits(["update:modelValue"]);

const computedValue = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit("update:modelValue", value);
    },
});
</script>

<template>
    <div>
        <CKEditor
            v-model="computedValue"
            :editor="txtEditor.editor"
            :config="txtEditor.editorConfig"
        />
        <div v-if="error" class="form-error mt-1">
            <span class="text-xs italic text-red-500"> {{ error }}</span>
        </div>
    </div>
</template>
