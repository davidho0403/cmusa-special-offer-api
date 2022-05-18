$(() => {
    getLocation();
});

const getLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(sendPosition, showError);
    } else {
        window.alert("The Browser Does not Support Geolocation");
    }
};

const showError = (error) => {
    if (error.PERMISSION_DENIED) {
        window.alert("The User have denied the request for Geolocation.");
    }
};

const display = (res) => {
    $('#store_id_1').html(res[0].store_name);
    $('#store_id_2').html(res[1].store_name);
    $('#store_id_3').html(res[2].store_name);
    $('#store_address_1').html(res[0].store_address);
    $('#store_address_2').html(res[1].store_address);
    $('#store_address_3').html(res[2].store_address);
    $('#store_phone_1').html(res[0].store_phone);
    $('#store_phone_2').html(res[1].store_phone);
    $('#store_phone_3').html(res[2].store_phone);
    $('#distance_1').html(res[0].distance);
    $('#distance_2').html(res[1].distance);
    $('#distance_3').html(res[2].distance);
}

const sendPosition = (position) => {
    let latitude = position.coords.latitude;
    let longitude = position.coords.longitude;
    let data = {
        latitude: latitude,
        longitude: longitude,
    };
    let json = JSON.stringify(data);
    $.ajax({
        url: "../backend/core.php",
        method: "POST",
        data: json,
        success: (res) => display(res),
    });
};