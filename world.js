document.addEventListener("DOMContentLoaded", () => {
    const lookupButton = document.getElementById("lookup");
    const resultDiv = document.getElementById("result");
    const countryInput = document.getElementById("country");

    lookupButton.addEventListener("click", () => {
        const country = countryInput.value;
        countryInput.value = ""
        
        const xhr = new XMLHttpRequest();
        xhr.onload = function () {
            console.log("XHR Status:", xhr.status);
            if (xhr.status === 200) {
                resultDiv.innerHTML = xhr.responseText;
            } else {
                resultDiv.innerHTML = `<p>Error: ${xhr.status}</p>`;
            }
        };

        xhr.onerror = function () {
            console.error("XHR request failed");
        };

        const url = `/info2180-lab5/world.php?country=${encodeURIComponent(country)}`;
        
        xhr.open("GET", url, true);
        xhr.send();
    });
});
