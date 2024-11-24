document.addEventListener("DOMContentLoaded", () => {
    const lookupButton = document.getElementById("lookup");
    const lookupCitiesButton = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");
    const countryInput = document.getElementById("country");

    const performLookup = (type) => {
        const country = countryInput.value;

        const xhr = new XMLHttpRequest();
        const url = `/info2180-lab5/world.php?country=${encodeURIComponent(country)}&lookup=${type}`;

        xhr.onload = function () {
            if (xhr.status === 200) {
                resultDiv.innerHTML = xhr.responseText;
            } else {
                resultDiv.innerHTML = `<p>Error: ${xhr.status}</p>`;
            }
        };

        xhr.onerror = function () {
            console.error("XHR request failed");
        };

        xhr.open("GET", url, true);
        xhr.send();
    };

    lookupButton.addEventListener("click", () => {
        performLookup("country");
    });

    lookupCitiesButton.addEventListener("click", () => {
        performLookup("cities");
    });
});
