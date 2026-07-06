// Frontend Image Modal Functions

function openImageModal(imageSrc, imageCaption) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const caption = document.getElementById('modalCaption');

    modal.style.display = 'block';
    modalImg.src = '/cms/uploads/' + imageSrc;
    caption.textContent = imageCaption;

    // ESCキーでモーダルを閉じる
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

function toggleFullText(btn) {
    const excerptText = btn.parentElement.querySelector('.excerpt-text');
    const isExpanded = btn.classList.contains('expanded');

    if (isExpanded) {
        excerptText.textContent = excerptText.dataset.excerpt.trim();
        btn.textContent = '全文表示';
        btn.classList.remove('expanded');
    } else {
        // textContentで安全に表示（white-space: pre-wrapで改行を維持）
        excerptText.textContent = excerptText.dataset.full.trim();
        btn.textContent = '閉じる';
        btn.classList.add('expanded');
    }
}
