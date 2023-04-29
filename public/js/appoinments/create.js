let doctor, date, specialty, iRadio;
let hoursMorning, hoursAfternon, titleMorning, titleAfternoon;

const titleMornings = `En la mañana`;
const titleAfternoons = `En la tarde`;
const noHours = `<h5 class="text-danger">No hay horas disponibles</h5>`;

$(function () {
    const specialty = $("#specialty");
    doctor = $("#doctor");
    date = $("#date");
    titleMorning = $("#titleMorning");
    hoursMorning = $("#hoursMorning");
    titleAfternoon = $("#titleAfternoon");
    hoursAfternon = $("#hoursAfternon");
    specialty.change(() => {
        const specialtyId = specialty.val();
        console.log(specialtyId);
        const url = `/especialidades/${specialtyId}/medicos`;
        console.log(url);
        $.getJSON(url, onDoctorsLoaded);
    });

    doctor.change(loadHours);
    date.change(loadHours);
});

function onDoctorsLoaded(doctors) {
    // console.log(doctors);
    let htmlOptions = "";
    doctors.forEach((doctor) => {
        htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
    });
    doctor.html(htmlOptions);
    loadHours();
}

function loadHours() {
    const selectedDate = date.val();
    const doctorId = doctor.val();
    const url = `/horario/horas?date=${selectedDate}&doctor_id=${doctorId}`;
    $.getJSON(url, displayHours);
}

function displayHours(data) {
    console.log(data);
    let htmlHoursM = "";
    let htmlHoursA = "";

    iRadio = 0;

    if (data.morning) {
        const morning_intervalos = data.morning;
        morning_intervalos.forEach((intervalo) => {
            htmlHoursM += getRadioIntervaloHTML(intervalo);
        });
    }

    if (!htmlHoursM != "") {
        htmlHoursM += noHours;
    }

    if (data.afternoon) {
        const afternoon_intervalos = data.afternoon;
        afternoon_intervalos.forEach((intervalo) => {
            htmlHoursA += getRadioIntervaloHTML(intervalo);
        });
    }

    if (!htmlHoursA != "") {
        htmlHoursA += noHours;
    }

    hoursMorning.html(htmlHoursM);
    hoursAfternon.html(htmlHoursA);
    titleMorning.html(titleMornings);
    titleAfternoon.html(titleAfternoons);
}

function getRadioIntervaloHTML(intervalo) {
    const text = `${intervalo.start} - ${intervalo.end}`;

    return `
    <div class="custom-control custom-radio mb-3">
        <input type="radio" id="interval${iRadio}" name="schedule_time" value="${intervalo.start}" class="custom-control-input" value="${text}" >
        <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
    </div>
    `;
}
