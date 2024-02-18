const absenceBtn = document.getElementById('btn-absence');
if (absenceBtn !== null)
    absenceBtn.addEventListener('click', getLocation);

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const lat = document.querySelector('#latitude input');
            const long = document.querySelector('#longitude input');

            if (lat !== null && long !== null) {
                lat.value = position.coords.latitude;
                long.value = position.coords.longitude;

                lat.dispatchEvent(new Event('input'));
                long.dispatchEvent(new Event('input'));

                // if (lat.value !== '' && long.value !== '') return
            }

            setTimeout(getLocation, 2000);
        });
    } else {
        lat.value = "Geolocation is not supported by this browser.";
    }
}
