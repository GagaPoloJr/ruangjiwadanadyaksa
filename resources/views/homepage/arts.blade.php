<div id="vote" class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
        Vote Karya Seni
        <div class="h-1 w-24 bg-amber-400 mx-auto mt-2 rounded-full"></div>
    </h2>

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

    let page = 1;
    document.getElementById("loadMore").addEventListener("click", function() {
        page++;

        fetch(`/load-more-artworks?page=${page}`)
            .then(response => response.text())
            .then(data => {
                if (data.trim()) {
                    document.getElementById("artwork-container").insertAdjacentHTML("beforeend", data);
                } else {
                    document.getElementById("loadMore").style.display =
                        "none";
                }
            })
            .catch(error => console.error("Error loading artworks:", error));
    });
</script>
