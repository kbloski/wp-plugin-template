jQuery(document).ready(function($) {
    // Podgląd zdjęć przed wysłaniem (limit 3 zdjęcia, max 4 MB każde)
    $('#wp_comment_images').on('change', function() {
        let files = Array.from(this.files);
        const maxFiles = 3;
        const maxSize = 4 * 1024 * 1024; // 4 MB

        if (files.length > maxFiles) {
            alert('Możesz dodać maksymalnie ' + maxFiles + ' zdjęcia.');
            this.value = '';
            $(this).nextAll('.image-preview').remove();
            return;
        }

        let preview = $('<div class="image-preview"></div>');
        $(this).nextAll('.image-preview').remove();
        $(this).after(preview);

        for (let file of files) {
            if (!file.type.startsWith('image/')) continue;
            if (file.size > maxSize) {
                alert(file.name + ' jest zbyt duże (maksymalnie 4 MB).');
                this.value = '';
                preview.remove();
                return;
            }

            let img = $('<img>');
            img.attr('src', URL.createObjectURL(file));
            img.on('load', function() {
                URL.revokeObjectURL(this.src); // zwolnij pamięć
            });
            preview.append(img);
        }
    });
});