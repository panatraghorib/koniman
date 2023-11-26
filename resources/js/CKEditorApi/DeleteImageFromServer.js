// Misalnya, dalam direktori 'custom-plugins/deleteImage'
// Buat file 'deleteimage.js'

import { Plugin } from "ckeditor5/src/core";

export default class DeleteImageFromServer extends Plugin {
    static get pluginName() {
        return "DeleteImageFromServer";
    }

    init() {
        const editor = this.editor;

        // Tambahkan peristiwa penghapusan gambar pada editor
        editor.ui.componentFactory.add("deleteImage", (locale) => {
            const view = new ButtonView(locale);

            view.set({
                label: "Hapus Gambar",
                icon: trashIcon,
                tooltip: true,
            });

            // Ketika tombol "Hapus Gambar" diklik
            view.on("execute", () => {
                const selectedImage =
                    editor.model.document.selection.getSelectedElement();

                if (selectedImage && selectedImage.is("element", "image")) {
                    const imageUrl = selectedImage.getAttribute("src");

                    // Kirim permintaan DELETE ke endpoint di server Laravel untuk menghapus gambar
                    fetch("/delete-image", {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ url: imageUrl }),
                    })
                        .then((response) => {
                            if (response.ok) {
                                console.log(
                                    "Gambar berhasil dihapus dari server."
                                );
                                // Hapus gambar dari editor setelah berhasil dihapus dari server
                                editor.model.change((writer) => {
                                    writer.remove(selectedImage);
                                });
                            } else {
                                console.error(
                                    "Gagal menghapus gambar dari server."
                                );
                            }
                        })
                        .catch((error) => {
                            console.error("Terjadi kesalahan:", error);
                        });
                }
            });

            return view;
        });
    }
}
