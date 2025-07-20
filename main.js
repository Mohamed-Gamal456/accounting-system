// دالة لتحميل الصفحات ديناميكيًا
function loadPage(pageName) {
    fetch(/views/${pageName}.html)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            
            // تحديث عنوان URL بدون إعادة تحميل الصفحة
            history.pushState(null, null, ?page=${pageName});
        })
        .catch(error => {
            console.error('Error loading page:', error);
            document.getElementById('main-content').innerHTML = `
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">حدث خطأ</h2>
                    <p>تعذر تحميل الصفحة المطلوبة.</p>
                </div>
            `;
        });
}

// تحميل الصفحة المطلوبة عند تحميل التطبيق
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const page = urlParams.get('page') || 'dashboard';
    loadPage(page);
});

// التعامل مع زر الرجوع في المتصفح
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const page = urlParams.get('page') || 'dashboard';
    loadPage(page);
});
