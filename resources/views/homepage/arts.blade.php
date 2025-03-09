<div id="vote" class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
        Vote Karya Seni
        <div class="h-1 w-24 bg-amber-400 mx-auto mt-2 rounded-full"></div>
    </h2>

    <div class="category-filters flex justify-center gap-5 items-center my-10">
        <button data-category=""
            class="category-btn pb-1 {{ request('category') == null ? 'text-amber-500 font-semibold border-b-2 border-amber-500' : 'text-gray-600 hover:text-amber-500' }}">
            Semua
        </button>
        <button data-category="goresan"
            class="category-btn pb-1 {{ request('category') == 'goresan' ? 'text-amber-500 font-semibold border-b-2 border-amber-500' : 'text-gray-600 hover:text-amber-500' }}">
            Goresan Perasaan
        </button>
        <button data-category="ekspresi"
            class="category-btn pb-1 {{ request('category') == 'ekspresi' ? 'text-amber-500 font-semibold border-b-2 border-amber-500' : 'text-gray-600 hover:text-amber-500' }}">
            Lukisan Ekspresi
        </button>
        <button data-category="larik"
            class="category-btn pb-1 {{ request('category') == 'larik' ? 'text-amber-500 font-semibold border-b-2 border-amber-500' : 'text-gray-600 hover:text-amber-500' }}">
            Larik Bermakna
        </button>
    </div>

    <div id="artwork-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
        @include('homepage.artwork-list')
    </div>

    @if ($artworks->hasMorePages())
        <div class="text-center">
            <button id="loadMore" class="bg-amber-500 text-white py-2 px-4 rounded-lg mt-4 hover:bg-amber-600">
                Load More
            </button>
        </div>
    @endif

</div>



<script>
    function openModal(artworkId) {
        document.getElementById("artwork_id").value = artworkId;
        document.getElementById("voteModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("voteModal").classList.add("hidden");
    }
</script>

<script>
    let page = 1;
    let currentCategory = null;

    document.addEventListener("DOMContentLoaded", function() {
        const categoryButtons = document.querySelectorAll(".category-filters button.category-btn");
        const artworkContainer = document.getElementById("artwork-container");
        const loadMoreBtn = document.getElementById("loadMore");

        categoryButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();

                // Remove active classes from all
                categoryButtons.forEach(btn => {
                    btn.classList.remove("text-amber-500", "font-semibold",
                        "border-b-2", "border-amber-500");
                    btn.classList.add("text-gray-600", "hover:text-amber-500");
                });

                // Add active classes to clicked
                this.classList.remove("text-gray-600", "hover:text-amber-500");
                this.classList.add("text-amber-500", "font-semibold", "border-b-2",
                    "border-amber-500");

                // Get category from data-category attribute
                currentCategory = this.getAttribute("data-category") || null;
                page = 1;

                // Build fetch URL
                let fetchUrl = `/load-more-artworks?page=${page}`;
                if (currentCategory) {
                    fetchUrl += `&category=${encodeURIComponent(currentCategory)}`;
                }

                fetch(fetchUrl)
                    .then(response => response.text())
                    .then(data => {
                        artworkContainer.innerHTML = data;

                        // Update URL without reload
                        const newUrl = currentCategory ?
                            `?category=${encodeURIComponent(currentCategory)}` : window
                            .location.pathname;
                        history.replaceState(null, '', newUrl);

                        // Show or hide Load More
                        if (data.trim()) {
                            loadMoreBtn?.classList.remove("hidden");
                        } else {
                            loadMoreBtn?.classList.add("hidden");
                        }
                    })
                    .catch(error => console.error("Error loading artworks:", error));
            });
        });

        // Load More handler
        loadMoreBtn?.addEventListener("click", function() {
            page++;

            let fetchUrl = `/load-more-artworks?page=${page}`;
            if (currentCategory) {
                fetchUrl += `&category=${encodeURIComponent(currentCategory)}`;
            }

            fetch(fetchUrl)
                .then(response => response.text())
                .then(data => {
                    if (data.trim()) {
                        artworkContainer.insertAdjacentHTML("beforeend", data);
                    } else {
                        loadMoreBtn.classList.add("hidden");
                    }
                })
                .catch(error => console.error("Error loading more artworks:", error));
        });
    });
</script>
