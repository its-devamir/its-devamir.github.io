const maForm = document.getElementById("maForm");
if (maForm) {
  maForm.addEventListener("submit", e => {

    const keysArr = ['username', 'password', 'gender', 'gpa', 'tag'];
    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = e.currentTarget;
    var actionUrl = "https://api.itsamir.com";
    let tag = form.elements.tag.value;
    let tag_wrapper = document.createElement("div");
    tag_wrapper.innerHTML = tag;
    let formData = new FormData(form);
    var object = {};
    formData.forEach((value, key) => object[key] = value);
    let checkAllKeys = keysArr.every((i) => object.hasOwnProperty(i));
    let check = keysArr.find(key => object[key] == '')
    if (!checkAllKeys, check) {
      alert('همه فیلدارو پر کن بینم')
      return;
    }
    var json = JSON.stringify(object);
    if (tag_wrapper.querySelector('table') || object.tag == "mobile") {
      $("#halle").html(`
      <div class="spinner-border" role="status">
  <span class="visually-hidden">Loading...</span>
</div>`);
      let request = $.ajax({
        type: "POST",
        url: actionUrl,
        data: json, // serializes the form's elements.
        // success: function(data)
        // {
        //   console.log(data); // show response from the php script.
        //   window.location.assign('/bot.html')
        // }
      });
      request.done(msg => {
        Cookies.set('API_KEY', msg.API_KEY);
        Cookies.set('name', msg.user.name);
        Cookies.set('username', msg.user.username);
        Cookies.set('gpa', msg.user.gpa);
        Cookies.set('password', msg.user.password);
        Cookies.set('gender', msg.user.gender);
        window.location.assign('bot.html')
      }).fail((jqXHR, textStatus) => {
        let j = jqXHR.responseJSON;
        alert(j.message);
      }).always(() => {
        $("#halle").html(`حله؟`);
      });

    } else {
      alert('تگ رو اشتباه کپی کردی')
    }


  });
}

// Function to load devil.js dynamically and execute it
function loadDevil() {
  // Get the API_KEY from cookies
  const apiKey = Cookies.get('API_KEY');

  if (!apiKey) {
    console.error('API_KEY is missing');
    return;
  }

  // Load devil.js using the /devil route
  $.ajax({
    url: 'https://api.itsamir.com/devil',
    type: 'GET',
    success: function (scriptContent) {
      // Dynamically load and execute the JS script
      try {
        eval(scriptContent);
        console.log('Devil script loaded and executed successfully.');
      } catch (error) {
        console.error('Error executing the devil script:', error);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Failed to load devil script:', textStatus, errorThrown);
    }
  });
}



const GPA = Cookies.get('gpa');
const GENDER = Cookies.get('gender');
const USERNAME = Cookies.get('username')
$('#theName').html(Cookies.get('name'))
let classes_table = document.getElementById("classes");
// let table = new DataTable('#classes');

let JSON_ARRAY = [];
const CLASSES = [];
const PASSED = [];
const UNITS_LIMIT = GPA == "a" ? 24 : 20;
let UNITS = 0;
const SELECTED = [];
const MAAREFI = [
  "اندیشه اسلامی 1 ( مبدا و معاد )",
  "اندیشه اسلامی 2 ( نبوت و امامت )",
  "انسان در اسلام",
  "حقوق اجتماعی و سیاسی در اسلام",
  "فلسفه اخلاق ( با تكیه بر مباحث تربیتی )",
  "آیین زندگی ( اخلاق كاربردی )",
  "عرفان عملی اسلامی",
  "اخلاق مهندسی",
  "انقلاب اسلامی ایران",
  "آشنایی با قانون اساسی جمهوری اسلامی ایران",
  "اندیشه سیاسی حضرت امام خمینی(ره)",
  "تاریخ تحلیلی صدر اسلام",
  "تاریخ امامت",
  "تاریخ فرهنگ و تمدن اسلام و ایران",
  "تفسیر موضوعی قرآن",
  "تفسیر موضوعی نهج البلاغه",
];
const NO_MAAREFI = [
  "دانش خانواده و جمعیت",
  "تربیت بدنی",
  "ورزش 1",
  "تربیت بدنی ویژه",
  "ورزش ویژه",
  "زبان فارسی",
  "زبان انگلیسی",
];

let MAAREFI_SELECTED = [];
let NO_MAAREFI_SELECTED = [];

function formatPersianText(input) {
  let formattedText = input.replace(/ك/g, "ک");
  formattedText = formattedText.replace(/ي/g, "ی");
  return formattedText;
}

function getKeyByValue(object, value) {
  if (object && value)
    return Object.keys(object).find((key) => object[key] === value);
  return null;
}

const gender_map = {
  'مختلط': "both",
  'مرد': "boy",
  'زن': "girl",
};
const dayMapping = {
  'شنبه': 1,
  'یک شنبه': 2,
  'دوشنبه': 3,
  'سه شنبه': 4,
  'چهارشنبه': 5,
  'پنج شنبه': 6,
  'جمعه': 7,
};
function cleanTitle(title) {
  return title.replace(/^\d+\s*/, "").trim(); // Remove leading digits and any following space
}
let fetchData;
fetch(`https://api.itsamir.com/tag?username=${USERNAME}`)
  .then(response => response.text())
  .then(data => {
    fetchData = data;
    doIt();
  })
  .catch(error => console.error('Error fetching the file:', error));
function doIt() {

  const data =
    formatPersianText(fetchData);
  const element = document.createElement("div");
  element.innerHTML = data;
  console.log(element)
  const table = element.querySelector("table:first-of-type");

  for (var i = 1, row; (row = table.rows[i]); i++) {
    let time_cell = row.cells[10].innerHTML;
    let time_lines = time_cell.split("<br>");
    let time = [];
    time_lines.forEach((line) => {
      if (line.trim() === "") return;
      let day, name, category, startTime, endTime;
      if (line.includes("امتحان")) {
        // It's an exam
        category = "exam";
        // Extract date and time
        const dateMatch = line.match(
          /امتحان\((\d{4}\.\d{2}\.\d{2})\)\s+ساعت\s*:\s*(\d{2}:\d{2})-(\d{2}:\d{2})/
        );
        if (dateMatch) {
          day = null; // Not needed for the exam
          date = dateMatch[1]; // Extract the exam date
          name = "امتحان";
          startTime = dateMatch[2];
          endTime = dateMatch[3];
        }
      } else {
        category = "class";
        const match = line.match(
          /(.+):\s*([^\d]+)\s+(\d{2}:\d{2})-(\d{2}:\d{2})/
        );
        if (match) {
          name = match[1].trim();
          day = dayMapping[match[2].trim()] ?? null;
          date = null; // No date for classes
          startTime = match[3];
          endTime = match[4];
        }
      }

      if (name && (day !== null || category === "exam")) {
        time.push({
          day: day,
          name: name,
          cat: category,
          start: startTime,
          end: endTime,
          date: date, // Add the date field
        });
      }
    });
    const requirements = [];

    let req_table = row.cells[12].querySelector("table");
    if (req_table) {  // Check if req_table exists
      for (var j = 0, req_row; (req_row = req_table.rows[j]); j++) {
        const rel = req_row.children[0].innerText.trim();
        let title = req_row.children[1].innerText.trim();
        title = cleanTitle(title);
        const exists = requirements.some((req) => req.title === title);
        if (!exists) {
          requirements.push({
            title: title,
            rel: rel,
          });
        }
      }
    } else {
      // Continue to the next iteration if there's no table
      continue;
    }
    console.log(row.cells[11].innerHTML, row.cells[4].textContent)
    let temp_no;
    if(row.cells[11].innerHTML == '')
      temp_no = "ندارد"
    else
      temp_no = row.cells[11].innerHTML.includes("مجازی") ? "online" : row.cells[11].innerHTML.match(/\b\d{3}\b/)[0];

    let JSON = {
      code: row.cells[3].textContent,
      title: row.cells[4].textContent,
      units: Number(row.cells[5].textContent),
      capacity: Number(row.cells[7].textContent),
      gender: gender_map[row.cells[8].textContent.trim()] ?? null,
      teacher: row.cells[9].textContent,
      time: time,
      class_no: temp_no ?? null,
      requirements: requirements,
    };
    JSON_ARRAY.push(JSON);
  }
  make_classes();
  //   console.log(JSON_ARRAY);
}
let selectedClassesTitles = [];
let selectedClassesCodes = [];
const selectedClasses = [];


const accordionTimeMaster = document.getElementById("accordionTimeMaster");
const unitOuttaUnits = document.getElementById("unitOuttaUnits");
const ulSelectedClasses = document.getElementById("ulSelectedClasses");
const selectTimeMasterBtn = document.getElementById("selectTimeMasterBtn");
const guideBox = document.getElementById("guideBox");
const passedBody = document.getElementById("passedBody");
const passedModal = new bootstrap.Modal('#passedModal', {
  keyboard: false
})
function make_classes() {
  let asked_passed = [];


  JSON_ARRAY.forEach((row, index) => {
    let reqs = row.requirements;
    reqs.forEach((req, i) => {
      // alert('wori')
      if (req.rel.includes("پ") && !asked_passed.includes(req.title)) {
        // if (confirm(`${req.title} رو پاس کردی؟`)) PASSED.push(req.title);
        asked_passed.push(req.title);
        passedBody.innerHTML += `<tr>
        <td class="text-start">
            <label class="form-check-label w-100 h-100" for="passed${index}_${i}">${req.title}</label>
        </td>
        <td>
            <div class="form-check form-switch d-flex justify-content-center">
                <input class="form-check-input" type="checkbox" role="switch" id="passed${index}_${i}">
            </div>
        </td>
    </tr>`;
      }
      // console.log(asked_passed);
    });
  });
  passedModal.show();

}
function make_classes_with_passed() {
  let data = [];
  let columns = [
    { title: "عنوان درس" },
    { title: "واحد" },
    // { title: "ظرفیت" },
    // { title: "ارائه" },
  ];

  passedModal.hide();
  for (var ii = 0, rr; (rr = passedBody.rows[ii]); ii++) {
    if (rr.cells[1].querySelector('input').checked)
      PASSED.push(rr.cells[0].innerText)
  }

  JSON_ARRAY.forEach((row) => {
    let has_this_class = false;
    let req_needed = false;
    let gender_limited = !["both", GENDER].includes(row.gender);
    CLASSES.forEach((el, index) => {
      if (el.title == row.title) has_this_class = true;
    });
    let reqs = row.requirements;
    reqs.forEach((req) => {
      if (req.rel.includes("پ") && !PASSED.includes(req.title))
        req_needed = true;
    });

    // if(![GENDER , 'both'].includes(el.gender)) gender_limited = true;
    //   class_reqs.forEach(req=>{
    //       if(req.rel=="پیش نیاز" && !PASSED.includes(req.title)) req_needed=true;
    //   })

    console.log(has_this_class, req_needed, gender_limited);
    if (!has_this_class && !req_needed && !gender_limited) CLASSES.push(row);
  });

  CLASSES.forEach((row) => {
    let time_it_has = "";
    let row_times = row.time;
    row_times.forEach((time) => {
      let temp = time.cat == "class" ? ['', getKeyByValue(dayMapping, time.day)] : ["امتحان", time.date];
      time_it_has += `<p>${temp[0]} ${temp[1]} ${time.start} - ${time.end}</p>`;
    });
    data.push([row.title, row.units, row.capacity, time_it_has]);
  });
  const tbl = new DataTable("#classes", {
    columns: columns, data: data,
    language: {
      url: './vendor/datatables.lang.json',
    },
    pageLength: 25
  });
  guideBox.classList.toggle('d-none');

  let tblSelecteds;
  tbl.on('click', 'tbody tr', function (e) {
    e.currentTarget.classList.toggle('selected');
    tblSelecteds = tbl.rows('.selected').data();
    let ulSelectedBody = '';
    let unitsSelectedTemp = 0;
    let selectedClassesTitlesTemp = [];
    for (let i = 0; i < tblSelecteds.length; i++) {
      if (unitOuttaUnits.classList.contains('text-danger')) unitOuttaUnits.classList.remove('text-danger');
      ulSelectedBody += `<li class="list-group-item"><div class="d-flex justify-content-between"><span>${tblSelecteds[i][0]}</span><span>${tblSelecteds[i][1]} واحد</span></div></li>`;
      unitsSelectedTemp += tblSelecteds[i][1];
      selectedClassesTitlesTemp.push(tblSelecteds[i][0]);
      unitOuttaUnits.innerHTML = `${unitsSelectedTemp}/${UNITS_LIMIT}`;
      console.log(tblSelecteds[i]);
    }
    selectedClassesTitles = selectedClassesTitlesTemp;
    ulSelectedClasses.innerHTML = ulSelectedBody;
    if (unitsSelectedTemp > UNITS_LIMIT) unitOuttaUnits.classList.add('text-danger')
    if (tblSelecteds.length == 0) ulSelectedClasses.innerHTML = 'هنوز هیچی انتخاب نکردی';
    selectTimeMasterBtn.classList.add('d-none');
    if (unitsSelectedTemp <= UNITS_LIMIT && tblSelecteds.length != 0)
      if (selectTimeMasterBtn.classList.contains('d-none')) selectTimeMasterBtn.classList.remove('d-none')
  });


  console.log({ columns: columns, data: data });

  console.log(CLASSES, PASSED);
}



selected_ids = [];
function get_class(title) {
  return JSON_ARRAY.find((c) => c.title === title);
}
function get_classes(title) {
  return JSON_ARRAY.filter((c) => c.title === title)
}
function get_class_by_code(code) {
  return JSON_ARRAY.find((c) => c.code === code);
}
function select_class(title) {
  let c = get_class(title);
  let err_msg = "";
  let units_limited = c.units + UNITS <= UNITS_LIMIT;
  if (units_limited)
    err_msg += `نمیتوانید بیش از ${UNITS_LIMIT} واحد بردارید \n`;
  let cat_limited =
    (MAAREFI_SELECTED && MAAREFI.includes(c.title)) ||
    (NO_MAAREFI_SELECTED && NO_MAAREFI.includes(c.title));
  if (cat_limited)
    err_msg += `نهایتا یک درس معارفی و یک درس غیر معارفی هر ترم میشه برداشت`;

  if (!units_limited && !cat_limited) SELECTED.push(c);
  else {
    alert(err_msg);
  }
}




selectTimeMasterBtn.addEventListener('click', () => {
  document.getElementById('rowClass').classList.add('d-none');

  // Clear previous tables if needed
  accordionTimeMaster.innerHTML = '';

  selectedClassesTitles.forEach((t, index) => {
    let classes_json = get_classes(t);
    let temp_code = classes_json[0].code.split('_')[0]
    if (!selectedClassesCodes.includes(temp_code)) selectedClassesCodes.push({ 'code': temp_code, 'group': null })
    let data = [];
    let columns = [
      { 'title': 'نام استاد' },
      { 'title': 'گروه' },
      { 'title': 'ظرفیت' },
      { 'title': 'ارائه' }
    ];

    // Prepare data array
    classes_json.forEach(row => {
      let time_it_has = "";
      let row_times = row.time;
      row_times.forEach((time) => {
        let temp = time.cat === "class" ? ['', getKeyByValue(dayMapping, time.day)] : ["امتحان", time.date];
        time_it_has += `<p class="m-0">${temp[0]} ${temp[1]} ${time.start} - ${time.end}</p>`;
      });
      data.push([row.teacher, row.code.split("_")[1], row.capacity, time_it_has]);
    });

    console.log(data);

    // Create and add table element
    let tbl_temp = document.createElement("table");
    tbl_temp.setAttribute("id", `timeMaster${index}`);
    tbl_temp.classList.add('display'); // Add display class for DataTables styling

    accordionTimeMaster.innerHTML += `
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapse${index}" aria-expanded="false"
            aria-controls="panelsStayOpen-collapse${index}">
            ${classes_json[0].title} (${classes_json[0].code.split("_")[0]}) : <span id="accordionBtn${index}" class="text-danger">کلاس انتخاب نشده</span>
          </button>
        </h2>
        <div id="panelsStayOpen-collapse${index}" class="accordion-collapse collapse" data-bs-parent="#accordionTimeMaster">
          <div class="accordion-body">
            <table id="timeMaster${index}" class="display"></table>
          </div>
        </div>
      </div>`;
    // Initialize DataTable after DOM is updated
    $(document).ready(function () {
      let data_tbl = $(`#timeMaster${index}`).DataTable({
        columns: columns,
        data: data,
        language: {
          url: './vendor/datatables.lang.json',
        },
        pageLength: 25,
        paging: false, // Enable pagination
        searching: false, // Disable searching
        info: false // Disable info display
      });
      data_tbl.on('click', 'tbody tr', (e) => {
        let classList = e.currentTarget.classList;

        if (classList.contains('selected')) {
          classList.remove('selected');
          document.getElementById(`accordionBtn${index}`).classList.remove('text-success');
          document.getElementById(`accordionBtn${index}`).classList.add('text-danger');
          document.getElementById(`accordionBtn${index}`).innerHTML = `کلاس انتخاب نشده`;
          selectedClassesCodes[index].group = null;

        }
        else {
          data_tbl.rows('.selected').nodes().each((row) => {
            // selectedClasses.push(row);
            row.classList.remove('selected')
          });
          document.getElementById(`accordionBtn${index}`).innerHTML = `گروه ${e.currentTarget.cells[1].innerText} انتخاب شده`;
          selectedClassesCodes[index].group = e.currentTarget.cells[1].innerText;
          document.getElementById(`accordionBtn${index}`).classList.remove('text-danger');
          document.getElementById(`accordionBtn${index}`).classList.add('text-success');
          classList.add('selected');
        }
      });
    });
  });

  accordionTimeMaster.innerHTML += `
<div class="d-flex justify-content-center py-5 ">
    <button class="btn btn-primary col-10 " type="button" onclick="wantThis()" >همین کلاسارو میخام</button>
  </div>`;
});



function numToTime(num) {
  let arr = String(num).split('.');
  let hour = arr[0].length < 2 ? '0' + arr[0] : arr[0];
  let minute = '00';
  if (arr.length > 1) {
    minute = Math.round(arr[1] * 0.6) + "0";
  }
  return hour + ":" + minute;
}
function timeToNum(time) {
  let arr = time.split(':');
  let hour = Number(arr[0]);
  let minute = Math.round(arr[1] * 1.6);
  return hour + minute;
}

// const weekTable = document.getElementById('weekTable');
// const weekTable_head = weekTable.querySelector('thead > tr');
// const weekTable_body = weekTable.querySelector('tbody');
// const START_TIME = 8;
// const END_TIME = 19;
// const STEPS_TIME = 0.5;
// const COLS_TIME = ((START_TIME-END_TIME) / STEPS_TIME) -1;
// for(let current = START_TIME;current <= END_TIME;current = current+STEPS_TIME) {
//   weekTable_head.innerHTML += `<th>${numToTime(current)}</th>`;
// }
// selectedClassesCodes.forEach((code) => {
//   let cl = get_class_by_code(code);
//   cl.time.forEach((time) => {
//     let cols = timeToNum(time.end) - timeToNum(time.start);
//     let trow = weekTable_body.querySelector(`tr:nth-child(${day})`);
//     trow.innerHTML+= `<td colspan="${cols}">${cl.title}</td>`
//   })
// })

function isBetween(num, min, max) {
  return num >= min && num <= max;
}
function wantThis() {
  UNITS = 0;
  MAAREFI_SELECTED.length = 0
  NO_MAAREFI_SELECTED.length = 0
  selectedClasses.length = 0
  selectedClassesCodesYup = selectedClassesCodes.filter((item) => item.group != null);
  selectedClassesCodesYup.forEach(item => {
    selectedClasses.push(get_class_by_code(item.code + "_" + item.group));
  })
  console.log(selectedClasses)
  let err_msg = "";
  let timeConflicts = [];
  let classes_body = "";
  let classesTimes = [];
  selectedClasses.forEach(cl => {
    UNITS += cl.units;
    if (MAAREFI.includes(cl.title)) MAAREFI_SELECTED.push(cl.title);
    if (NO_MAAREFI.includes(cl.title)) NO_MAAREFI_SELECTED.push(cl.title);

    cl.time.forEach(t => {
      if (t.name == "درس(ت)") classesTimes.push(t);
      t.title = cl.title;
    })
    selectedClasses.forEach(c => {
      if (c.title == cl.title) return;
      c.time.forEach(t => {
        cl.time.forEach(clT => {

          if (t.day == clT.day && t.name == "درس(ت)" && clT.name == "درس(ت)") {
            if (isBetween(clT.start, t.start, t.end) || isBetween(clT.end, t.start, t.end || isBetween(t.start, clT.start, clT.end)) || isBetween(t.end, clT.start, clT.end)) {
              let alreadyConflicts = false;
              timeConflicts.forEach(tc => {
                if (tc.title1 == c.title && tc.title2 == cl.title) alreadyConflicts = true;
              })
              if (!alreadyConflicts) timeConflicts.push({ title1: cl.title, title2: c.title, day: clT.day })
            }
          }
        })
      })
    })
  })
  console.log(MAAREFI, NO_MAAREFI, MAAREFI_SELECTED, NO_MAAREFI_SELECTED)
  if (MAAREFI_SELECTED.length > 1 || NO_MAAREFI_SELECTED.length > 1) {
    err_msg += `<p class="text-danger m-0">نهایتا یک درس معارفی با یک درس غیر معارفی هر ترم میشه برداشت</p>`;
    if (MAAREFI_SELECTED.length) err_msg += `<p class="text-info m-0">غیرمعارفیا که برداشتی: ${MAAREFI_SELECTED.join(" - ")}</p>`;
    if (NO_MAAREFI_SELECTED.length) err_msg += `<p class="text-info mb-2"> معارفیات : ${NO_MAAREFI_SELECTED.join(" - ")}</p>`;
    err_msg += '<br>'
  }
  timeConflicts.forEach(tc => {

    if (tc.day) err_msg += `<p class="text-danger">${tc.title1} و ${tc.title2}  ${getKeyByValue(dayMapping, tc.day)} میرن تو هم</p>`;
    console.log(tc)
  })
  console.log(classesTimes)
  let classesTimesSortedByDay = classesTimes.sort((a, b) => a.day - b.day || timeToNum(a.start) - timeToNum(b.start));
  console.log(classesTimesSortedByDay)
  let currentDay = classesTimesSortedByDay[0].day;
  classes_body += `<table class="table"><tr><td>${getKeyByValue(dayMapping, currentDay)}</td><td>`;
  classesTimesSortedByDay.forEach(tc => {
    console.log(tc)
    if (tc.day > currentDay) {
      classes_body += `</td></tr><tr><td> ${getKeyByValue(dayMapping, tc.day)}</td><td>`
    }
    currentDay = tc.day
    classes_body += `<p class="m-0">${tc.end}-${tc.start} : ${tc.title} </p> `;
  })
  classes_body += "</td></tr></table>";
  let selectedModal_body = document.getElementById("selectedModal").querySelector('.modal-body');
  selectedModal_body.innerHTML = `<div>${err_msg}</div>`;
  selectedModal_body.innerHTML += `<div><p> ${UNITS} واحد از ${UNITS_LIMIT} برداشتی</p>${classes_body}</div>`;


  const selectedModal = new bootstrap.Modal('#selectedModal', {
    keyboard: false
  })
  selectedModal.show();
}

function generateCode() {
  let str = `let tmp;`;
  let arrayOfCodes = [];
  let cd = [];
  selectedClasses.forEach(cl => {
    cd.push(cl.code);
    let code = cl.code.split("_")[0];
    let group = cl.code.split("_")[1];
    group = group.length < 2 ? "0" + group : group;
    arrayOfCodes.push({ group: cl.code.split("_")[1], code1: code.slice(0, 2), code2: code.slice(2, 4), code3: code.slice(4, 7) })
  })
  arrayOfCodes.forEach(c => {
    str += `tmp = AddRowT01();`;
    str += `tmp.cells[2].querySelector('input').value = '${c.group}';`;
    str += `tmp.cells[3].querySelector('input').value = '${c.code3}';`;
    str += `tmp.cells[4].querySelector('input').value = '${c.code2}';`;
    str += `tmp.cells[5].querySelector('input').value = '${c.code1}';`;
  })
  var actionUrl = "https://api.itsamir.com/store";
  var json = JSON.stringify({
    "api_key":Cookies.get('API_KEY'),
    "codes":cd.join(",")
  });

    let request = $.ajax({
      type: "POST",
      url: actionUrl,
      data: json,
    });
    request.done(msg => {
      console.log('done codes')
    }).fail((jqXHR, textStatus) => {
      let j = jqXHR.responseJSON;
      console.log(j.message);
    })
  navigator.clipboard.writeText(str);
  alert("کد اینجکت کپی شد :)")
  console.log(str);
}