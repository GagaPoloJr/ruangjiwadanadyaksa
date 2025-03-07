<div class="text-center bg-amber-500 pt-1">
    @php
        $isVotingEnded = now()->greaterThanOrEqualTo($votingDeadline);
    @endphp

    @if (!$isVotingEnded)
        <div class="text-center mt-5">
            <h2 class="text-white text-2xl font-bold">Voting Berakhir:</h2>
        </div>
    @endif

    <div id="countdown" class="flex items-center justify-center gap-3 text-white p-4 rounded-lg shadow-lg">
        <div class="flex flex-col items-center">
            <span id="days" class="text-4xl font-bold">0</span>
            <span class="text-sm uppercase">Hari</span>
        </div>
        <span class="text-2xl font-bold">:</span>
        <div class="flex flex-col items-center">
            <span id="hours" class="text-4xl font-bold">0</span>
            <span class="text-sm uppercase">Jam</span>
        </div>
        <span class="text-2xl font-bold">:</span>
        <div class="flex flex-col items-center">
            <span id="minutes" class="text-4xl font-bold">0</span>
            <span class="text-sm uppercase">Menit</span>
        </div>
        <span class="text-2xl font-bold">:</span>
        <div class="flex flex-col items-center">
            <span id="seconds" class="text-4xl font-bold">0</span>
            <span class="text-sm uppercase">Detik</span>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deadline = new Date("{{ $votingDeadline }}").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = deadline - now;

            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                document.getElementById("days").textContent = days;
                document.getElementById("hours").textContent = hours;
                document.getElementById("minutes").textContent = minutes;
                document.getElementById("seconds").textContent = seconds;
            } else {
                document.getElementById("countdown").innerHTML =
                    "<p class='text-white-500 text-xl font-bold'>Voting Sudah Berakhir! Terima kasih atas partisipasinya</p>";
                clearInterval(timer);
            }
        }

        // Update countdown every second
        const timer = setInterval(updateCountdown, 1000);
        updateCountdown();
    });
</script>
