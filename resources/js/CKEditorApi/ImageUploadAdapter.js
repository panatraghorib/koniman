import axios from "axios";

export default class MyUploadAdapter {
    constructor(loader) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file.then(
            (file) =>
                new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append("image", file);

                    // Kirim gambar ke endpoint Laravel
                    axios
                        .post("/upload-image", formData, {
                            headers: {
                                "content-type": "multipart/form-data",
                            },
                            signal: this.abort(),
                        })
                        .then((response) => {
                            // Resolusi dengan URL gambar yang diunggah
                            resolve({ default: response.data.url });
                        })
                        .catch((error) => {
                            // Tangani kesalahan saat pengunggahan gambar
                            reject(error);
                        });
                })
        );
    }

    // Aborts the upload process.
    abort() {
        const abortController = new AbortController();
        setTimeout(() => abortController.abort(), 5000 || 0);

        return abortController.signal;
    }
}
