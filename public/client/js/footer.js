document.querySelectorAll('.news-info209 p').forEach(function(p) {
    const maxLength = 100; // Độ dài tối đa trước khi cắt

    if (p.textContent.length > maxLength) {
        const truncated = p.textContent.slice(0, maxLength) + '...';
        p.textContent = truncated;
    }
});
