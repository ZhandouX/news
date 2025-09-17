CKEDITOR.replace('content', {
    height: 400,

    // Aktifkan plugin Styles + PasteFromWord
    extraPlugins: 'stylescombo,pastefromword',

    // Daftar style kustom
    stylesSet: 'default',
    stylesSet: [
        { name: 'Judul Berita', element: 'h2', attributes: { 'class': 'judul-berita' } },
        { name: 'Subjudul', element: 'h3', attributes: { 'class': 'subjudul-berita' } },
        { name: 'Highlight', element: 'span', attributes: { 'class': 'highlight' } },
        { name: 'Catatan', element: 'p', attributes: { 'class': 'catatan' } }
    ],

    // Atur toolbar
    toolbar: [
        { name: 'styles', items: ['Styles', 'Format'] },
        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'] },
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
        { name: 'insert', items: ['Image', 'Table', 'Link', 'Unlink'] },
        { name: 'editing', items: ['Scayt'] },
        { name: 'document', items: ['Source'] }
    ],

    pasteFromWordRemoveFontStyles: true,
    pasteFromWordRemoveStyles: false
});

// Preview cover image
document.getElementById('cover_image').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        document.getElementById('image-preview').style.display = 'none';
    }
});