import "./styles/reservations.scss";

$(document).ready(function () {
  let reservationDate = document.querySelector(".reservedDate");
  let reservationTimeHours = document.querySelector(
    "#reserved_table_reservedTime_hour"
  );
  let reservationTimeMinutes = document.querySelector(
    "#reserved_table_reservedTime_minute"
  );
  let schedule = document.querySelector(".schedule-hours");
  let printChoiceTime = document.querySelector(".printChoiceTime");
  let domReservedTime = document.querySelector(".reservedTime");
  domReservedTime.value = "";
  let form = document.querySelector("form");
  let chooseTime = document.querySelector(".choose-time");
  form.addEventListener("submit", (e) => {
    // console.log("Form event");
    e.preventDefault();
    if (domReservedTime.value === "" || domReservedTime.value === null)
      chooseTime.innerText = "Veuillez choisir une heure";
    else form.submit();
  });
  reservationDate.addEventListener("blur", async () => {
    let reservedDate = new Date(reservationDate.value);
    let schedule = await sendTimestamp(reservedDate.getTime());
    // console.log(schedule);
    updateReservedTime(schedule);
  });

  async function sendTimestamp(timestamp) {
    let body = JSON.stringify({
      timestamp: timestamp,
    });
    const init = {
      method: "POST",
      body: body,
    };
    return fetch("/handle/reservation", init)
      .then((response) => {
        return response.json();
      })
      .catch((error) => console.log("Error: " + error));
  }

  function updateReservedTime(schedule) {
    let opening = {
      hour: new Date(schedule.openingTime.date).getHours(),
      minute: new Date(schedule.openingTime.date).getMinutes(),
    };
    let closingTime = {
      hour: new Date(schedule.closingTime.date).getHours(),
      minute: new Date(schedule.closingTime.date).getMinutes(),
    };
    let breakStart = {
      hour: new Date(schedule.breakStartTime.date).getHours(),
      minute: new Date(schedule.breakStartTime.date).getMinutes(),
    };
    let breakEnd = {
      hour: new Date(schedule.breakEndTime.date).getHours(),
      minute: new Date(schedule.breakEndTime.date).getMinutes(),
    };
    let workTime = range(
      opening.hour,
      closingTime.hour == 0 ? 23 : closingTime.hour
    );
    let breakTime = range(breakStart.hour, breakEnd.hour);
    let realWorkTime = workTime.filter((hour) => !breakTime.includes(hour));

    let realWorkMinute = range(0, 59, 15);

    // realWorkTime
    //   .map((hour) => {
    //     let option = document.createElement("option");
    //     option.value = hour + 1;
    //     option.text = hour;
    //     return option;
    //   })
    //   .forEach((option) => reservationTimeHours.append(option));

    // reservationTimeMinutes.innerHTML = "";
    // realWorkMinute
    //   .map((minute) => {
    //     let option = document.createElement("option");
    //     option.value = minute;
    //     option.text = minute;
    //     return option;
    //   })
    //   .forEach((option) => reservationTimeMinutes.append(option));

    fullfillSchedule(realWorkTime, realWorkMinute, schedule.reservedTimes);
  }

  function fullfillSchedule(realWorkTime, realWorkMinute, reservedTimes) {
    let alreadyReserved = reservedTimes.map((reservedTime) => {
      let alreadyTime = new Date(reservedTime.date);
      return alreadyTime.getHours() + ":" + alreadyTime.getMinutes();
    });
    schedule.innerHTML = "";
    realWorkTime.map((hour) => {
      realWorkMinute
        .map((minute) => {
          let choiceTime = document.createElement("div");
          let availableHour = hour + ":" + minute;
          choiceTime.innerText = availableHour;
          alreadyReserved.includes(availableHour)
            ? choiceTime.setAttribute("class", "disable")
            : null;
          choiceTime.addEventListener("click", (e) => {
            if (!e.target.classList.contains("disable")) {
              printChoiceTime.innerText = e.target.innerText;
              let time = e.target.innerText.split(":");
              reservationTimeHours.value = parseInt(time[0]);
              reservationTimeMinutes.value = time[1];
              domReservedTime.value = "Time Set";
              // console.log(parseInt(time[0]) + 1, typeof(time[0]));
            }
          });
          return choiceTime;
        })
        .forEach((element) => schedule.append(element));
    });
  }

  var range = function (start, end, step) {
    var range = [];
    var typeofStart = typeof start;
    var typeofEnd = typeof end;

    if (step === 0) {
      throw TypeError("Step cannot be zero.");
    }

    if (typeofStart == "undefined" || typeofEnd == "undefined") {
      throw TypeError("Must pass start and end arguments.");
    } else if (typeofStart != typeofEnd) {
      throw TypeError("Start and end arguments must be of same type.");
    }

    typeof step == "undefined" && (step = 1);

    if (end < start) {
      step = -step;
    }

    if (typeofStart == "number") {
      while (step > 0 ? end >= start : end <= start) {
        range.push(start);
        start += step;
      }
    } else if (typeofStart == "string") {
      if (start.length != 1 || end.length != 1) {
        throw TypeError("Only strings with one character are supported.");
      }

      start = start.charCodeAt(0);
      end = end.charCodeAt(0);

      while (step > 0 ? end >= start : end <= start) {
        range.push(String.fromCharCode(start));
        start += step;
      }
    } else {
      throw TypeError("Only string and number types are supported");
    }

    return range;
  };
});
