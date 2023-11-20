// Function Smooth Back To Top
function backToTop({ element }) {
  element.scrollTo({
    top: 0,
    behavior: "smooth",
  });
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

// Show Error Message In Table
function tableError({ col, code }) {
  return `
    <tr>
      <td colspan="${col}">
        <div class="tbLoading">
          <h2>Error ${code}</h2>
          <p>Terjadi kesalahan!</p>
        </div>
      </td>
    </tr>
  `;
}

// Show Loading In Tabel
function tableLoading({ col, element }) {
  element.map((list) => {
    const tag = document.getElementById(list);
    tag.innerHTML = "";
  });
  return `
  <tr>
    <td colspan="${col}">
      <div class="table_loading">
        <img src="${baseURL}assets/icons/loading-line-black-1.svg" alt="loading-line" />
      </div>
    </td>
  </tr>`;
}

// Function for running funtion first reload page
function loadData({ text, fnc }) {
  var href = window.location.href;
  var getIndex = href.indexOf(text);
  var link = href.slice(getIndex, getIndex + text.length);
  if (link == text) {
    window.addEventListener("load", () => {
      eval(fnc);
    });
  }
}

function paginateButton({ table, col, url }) {
  table.innerHTML = tableLoading({
    col: col,
    element: ["paginate_button", "paginate_text"],
  });
  const searchInput = document.getElementById("goods_input_search");
  const keyword = searchInput.value;
  if (keyword) {
    goodsSearch({ url });
  } else {
    goodsList({ url });
  }
  backToTop({ element: containerPage });
}

// Paginate Button
function paginateBtn({ data, table, col }) {
  const btnBack = document.getElementById("paginate_button");
  const textPaginate = document.getElementById("paginate_text");
  if (data.backPage) {
    btnBack.innerHTML += `<button onclick="paginateButton({table: '${table}', col: ${col}, url: '${data.backPage}'})" class="back">Kembali</button>`;
  }
  if (data.nextPage) {
    btnBack.innerHTML += `<button onclick="paginateButton({table: '${table}', col: ${col}, url: '${data.nextPage}'})" class="next">Berikutnya</button>`;
  }
  if (data.totalItems >= 1) {
    textPaginate.innerHTML = `
        <span>Halaman</span>
        <span>${data.currentPage}</span>
        <span>dari</span>
        <span>${data.pageCount}</span>
        <span>(${data.totalItems} Barang)</span>
    `;
  }
}

// Copy And Message Copy Text
function copyTextToClipboard({ copyText }) {
  const textArea = document.createElement("textarea");
  const messageCopy = document.getElementById("message_copy");
  textArea.value = copyText;
  document.body.appendChild(textArea);
  textArea.select();
  document.execCommand("copy");
  document.body.removeChild(textArea);
  messageCopy.show();
  setInterval(() => {
    messageCopy.close();
  }, 3000);
}

// Confimation Message
let messageTimeOut;
function messageConfirmation({ icons, title, text, form }) {
  const messageConfirmation = document.getElementById("message_confirmation");

  if (messageConfirmation.open) {
    closeConfirmation({ element: "message_confirmation" });
  }
  clearTimeout(messageTimeOut);

  messageConfirmation.show();
  messageConfirmation.innerHTML = `
  <div class="parent">
    <div class="bg_parent"></div>
    <div class="child">
      <div>
        <img src="${baseURL}assets/icons/${icons}.svg" alt="icons">
        <h2>${title}</h2>
      </div>
      <div></div>
      <h2>${text}</h2>
      <div>
        <button class="hoverCancle" onclick="closeConfirmation({element: 'message_confirmation'})" id="btnCancleMessage">Batal</button>
        <button class="hoverContinue" onclick="confirmation({ form: '${form}' })" id="buttonLoading">Lanjutkan</button>
      </div>
    </div>
  </div>`;

  messageTimeOut = setTimeout(() => {
    closeConfirmation({ element: "message_confirmation" });
  }, 5000);
}

// Close Dialog
function closeConfirmation({ element }) {
  const messageConfirmation = document.getElementById(element);
  messageConfirmation.close();
}

// Message Confimation Form
function confirmation({ form }) {
  const formTag = document.getElementById(form);
  const buttonLoading = document.getElementById("buttonLoading");
  const btnCancleMessage = document.getElementById("btnCancleMessage");

  if (btnCancleMessage) {
    btnCancleMessage.disabled = true;
    btnCancleMessage.classList.remove("hoverCancle");
  }

  buttonLoading.disabled = true;
  buttonLoading.classList.remove("hoverContinue");
  buttonLoading.innerHTML = `
    <img src="${baseURL}assets/icons/loading-line-black-1.svg" alt="loading-line" class="loading"/>
  `;
  formTag.submit();
}

// Notification Message
let notifTimeOut;
function notification({ notif }) {
  const notificationMessage = document.getElementById("notification_message");
  if (notificationMessage.open) {
    closeConfirmation({ element: "notification_message" });
  }
  clearTimeout(notifTimeOut);

  notificationMessage.show();
  notificationMessage.innerHTML = `
    <div class="parent">
      <div class="child">
        <div class="last_child">
          <img src="${baseURL}assets/icons/bell-line-black-1.svg" alt="notification-line-1">
          <h2>${notif.title}</h2>
          <button type="button" onclick="closeConfirmation({element: 'notification_message'})">
            <img src="${baseURL}assets/icons/close-line-1.svg" alt="close-line-1">
          </button>
        </div>
      </div>
    </div>`;

  notifTimeOut = setTimeout(() => {
    closeConfirmation({ element: `notification_message` });
  }, 3000);
}
