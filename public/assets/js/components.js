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

function tableLoading({ col, element }) {
  element.map((list) => {
    const tag = document.getElementById(list);
    tag.innerHTML = "";
  });
  return `
  <tr>
    <td colspan="${col}">
      <div class="tbLoading">
        <img src="${baseURL}/assets/icons/loading.gif" alt="loading" class="spiner">
        <p>Loading...</p>
      </div>
    </td>
  </tr>`;
}

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
  const searchInput = document.getElementById("cs_input_search");
  const keyword = searchInput.value;
  if (keyword) {
    csSearch({ url });
  } else {
    getGoods({ url });
  }
  backToTop({ element: containerPage });
}

function paginateBtn({ data, table, col }) {
  const btnBack = document.getElementById("paginate_button");
  const textPaginate = document.getElementById("paginate_text");
  if (data.backPage) {
    btnBack.innerHTML += `<button onclick="paginateButton({table: '${table}', col: ${col}, url: '${data.backPage}'})" class="back">Back</button>`;
  }
  if (data.nextPage) {
    btnBack.innerHTML += `<button onclick="paginateButton({table: '${table}', col: ${col}, url: '${data.nextPage}'})" class="next">Next</button>`;
  }
  if (data.totalItems >= 1) {
    textPaginate.innerHTML = `
        <span>Page</span>
        <span>${data.currentPage}</span>
        <span>of</span>
        <span>${data.pageCount}</span>
        <span>(${data.totalItems} Barang)</span>
    `;
  }
}

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
    <div class="child">
      <div>
        <img src="${baseURL}assets/icons/${icons}.svg" alt="icons">
        <h2>${title}</h2>
      </div>
      <div></div>
      <h2>${text}</h2>
      <div>
        <button class="hoverCancle" onclick="closeConfirmation({element: 'message_confirmation'})" id="btnCancleMessage">Batal</button>
        <button class="hoverContinue" onclick="formConfirmation({ form: '${form}' })" id="buttonLoading">Lanjutkan</button>
      </div>
    </div>
  </div>`;

  messageTimeOut = setTimeout(() => {
    closeConfirmation({ element: "message_confirmation" });
  }, 5000);
}

function closeConfirmation({ element }) {
  const messageConfirmation = document.getElementById(element);
  messageConfirmation.close();
}

function formConfirmation({ form }) {
  const formTag = document.getElementById(form);
  const buttonLoading = document.getElementById('buttonLoading');
  const btnCancleMessage = document.getElementById('btnCancleMessage');
  
  if(btnCancleMessage) {
    btnCancleMessage.disabled = true;
    btnCancleMessage.classList.remove('hoverCancle');
  }

  buttonLoading.disabled = true;
  buttonLoading.classList.remove('hoverContinue');
  buttonLoading.innerHTML = "Loading...";
  formTag.submit();
}

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
