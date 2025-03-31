document.addEventListener('DOMContentLoaded', function () {
    fetchData();
    setInterval(function() {
        console.log('Fetching data...');
        fetchData();
    }, 3600000); // Auto-refresh every 60 minute
});

function fetchData() {
    console.log('Starting data fetch...');
    document.getElementById("loading").style.display = "block";

    fetch('fetch_data.php')
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then(text => {
            if (text.trim() === "") {
                throw new Error("Empty response received");
            }
            return JSON.parse(text);
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            const tbody = document.querySelector("#taskTable tbody");
            tbody.innerHTML = "";

            data.forEach(task => {
                const row = `<tr>
                    <td class="w-7">${task.task}</td>
                    <td class="w-26">${task.title}</td>
                    <td class="w-60">${task.description}</td>
                    <td class="w-7"><span class="color-box" style="background:${task.colorCode};">${task.colorCode}</span></td>
                </tr>`;
                tbody.innerHTML += row;
            });
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            alert("Failed to fetch task data: " + error.message);
        })
        .finally(() => {
            document.getElementById("loading").style.display = "none";
        });
}

let debounceTimer;
function filterTable() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        let input = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#taskTable tbody tr");

        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(input) ? "" : "none";
        });
    }, 300);
}

function openModal() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("modal").style.display = "block";
}

function closeModal() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("modal").style.display = "none";
}

document.getElementById("imageInput").addEventListener("change", function(event) {
    let reader = new FileReader();
    reader.onload = function() {
        document.getElementById("selected-image").src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});
