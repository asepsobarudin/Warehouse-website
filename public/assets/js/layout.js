function tableGoods({ no, value }) {
  let btnCart = "";
  if (status == 0) {
    btnCart = `
    <td>
      <button class="buttonInfo" onclick="addCartRestock({goods: '${value.goods_code}', btn: ${no} })" id="addCartRestock${no}">
        <img src="${baseURL}assets/icons/cart-line-plus-white-1.svg" alt="add-line">
        <img src="${baseURL}assets/icons/cart-line-plus-blue-1.svg" alt="add-line">
        <h2>Tambahkan</h2>
      </button>
    </td>
    `;
  }
  return `
    <tr>
      <td>${no}</td>
      <td>${value.goods_name}</td>

      <td>
        <span>Gudang : </span>
        <span>${value.goods_stock_warehouse}</span>
      </td>
      ${btnCart}
    </tr>
  `;
}

function cardCartCardRestock({ no, value, status }) {
  let inputV = null;
  let deleteBtn = "<div></div>";
  let setBtn = "<div></div>";

  if (status == 1) {
    inputV = `<input type="number" id="qty${no}" value="${value.qty}" disabled >`;
  } else {
    inputV = `<input type="number" id="qty${no}" value="${value.qty}" >`;
    deleteBtn = `
                  <button class="buttonDanger" id="buttonDelete${no}" onclick="removeCartRestock({ restock: '${value.restock_code}', goods: '${value.goods_code}', no: ${no} })">
                    <img src="${baseURL}assets/icons/trash-line-white-1.svg" alt="trash-line">
                      <img src="${baseURL}assets/icons/trash-line-red-1.svg" alt="trash-line">
                  </button>`;
  }

  if(value.check == 0) {
    setBtn = `
      <button class="buttonInfo" id="btnQty${no}" onclick="addCardRestockQty({no: ${no}, goods:'${value.goods_code}', restock:'${value.restock_code}'})">Set</button>
    `;
  } else {
    setBtn = `<div></div>`
  }

  return `
    <div class="card_cart_restock">
      <div>
        <h2>${no}.</h2>
        <h2>${value.goods_name}</h2>
      </div>
      <div>
        ${deleteBtn}
        <label for="qty">
          ${inputV}
          ${setBtn}
        </label>
      </div>
    </div>
  `;
}

function TabelPageGoods({ value, no }) {
  const number = parseInt(value.goods_price);
  const fixedNumber = number.toFixed(0);
  const numberWithCommas = fixedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  const goodsCode = value.goods_code;
  var code = goodsCode.substring(0, 5) + "...";
  var detailBtn = ``;

  if (role != "kasir") {
    detailBtn = `
      <td>
        <div>
          <a href="${siteURL}/goods/edit/${value.goods_code}" class="buttonInfo">
            <img src="${baseURL}/assets/icons/details-line-white-1.svg" alt="eye">
            <img src="${baseURL}/assets/icons/details-line-blue-1.svg" alt="eye">
            <h2>Detail</h2>
          </a>
        </div>
      </td>
    `;
  }

  return `
    <tr>
      <td>${no}</td>
      <td>
        <div>
          ${code}
          <button class="copy" onclick="copyTextToClipboard({copyText: '${value.goods_code}'})">
            <img src="${baseURL}/assets/icons/copy-line-1.svg" alt="copy-line-1">
          </button>
        </div>
      </td>
      <td>${value.goods_name}</td>
      <td>
        <div>
          <span>Harga : </span>
          <span>Rp ${numberWithCommas}</span>
        </div>
      </td>
      <td>
        <div>
          <span>Stok : </span>
          <span>${value.goods_stock_warehouse}</span>
        </div>
      </td>
      ${detailBtn}
    </tr>
  `;
}

function TabelPageRestock({ value, no }) {
  var status = ``;
  var setButton = ``;
  if (value.status == 0) {
    status = `
      <span>
        <img src="${baseURL}assets/icons/edit-line-black-1.svg" alt="edit-line">
      </span>
    `;
    setButton = `
      <a href="${siteURL}/restock/edit/${value.restock_code}" class="buttonWarning">
        <img src="${baseURL}assets/icons/edit-line-white-1.svg" alt="edit-line">
        <img src="${baseURL}assets/icons/edit-line-yellow-1.svg" alt="edit-line">
      </a>
      <form action="${siteURL}/restock/delete" method="post" id="form_restock_delete${no}">
            <input type="hidden" name="csrf_test_name" value="${csrfToken.defaultValue}">
            <input type="hidden" value="${value.restock_code}" name="restock">
            <button type="button" class="buttonDanger" onclick="messageConfirmation({ title: 'Hapus Permintaan', text: 'Apakah yakin ingin menghapus permintaan restock?', form: 'form_restock_delete${no}' })">
              <img src="${baseURL}assets/icons/trash-line-white-1.svg" alt="trash-line-1">
              <img src="${baseURL}assets/icons/trash-line-red-1.svg" alt="trash-line-1">
            </button>
          </form>
    `;
  }

  if (
    ((value.status == 1 || value.status == 2) && role == "kasir") ||
    (value.status == 2 && (role == "gudang" || role == "admin"))
  ) {
    status = `
      <span>
        <img src="${baseURL}assets/icons/send-line-black-1.svg" alt="edit-line">
      </span>
    `;
    setButton = `
      <a href="${siteURL}/restock/details/${value.restock_code}" class="buttonInfo">
        <img src="${baseURL}assets/icons/details-line-white-1.svg" alt="details-line">
        <img src="${baseURL}assets/icons/details-line-blue-1.svg" alt="details-line">
      </a>
    `;
  }

  if (value.status == 1 && (role == "gudang" || role == "admin")) {
    status = `
      <span>
        <img src="${baseURL}assets/icons/package-line-black-1.svg" alt="edit-line">
      </span>
    `;
    setButton = `
      <a href="${siteURL}/restock/edit/${value.restock_code}" class="buttonWarning">
        <img src="${baseURL}assets/icons/edit-line-white-1.svg" alt="edit-line">
        <img src="${baseURL}assets/icons/edit-line-yellow-1.svg" alt="edit-line">
      </a>
    `;
  }

  if (value.status == 2) {
    status = `
      <span>
        <img src="${baseURL}assets/icons/van-line-black-1.svg" alt="edit-line">
      </span>
    `;
  }

  var viewRole = ``;
  if (role == "admin") {
    viewRole = `
      <td>
        <div>
          <span>User : </span>
          <span>
              ${value.user_id}
          </span>
        </div>
      </td>
    `;
  }

  return `
    <tr>
      <td>${no}</td>
      <td>
        ${value.updated_at}
      </td>
      <td>
        <div>
          ${value.restock_code}
        </div>
      </td>
      <td>
        <div>
          ${status}
        </div>
      </td>
      ${viewRole}
      <td>
        <div>
          <span>Jumlah : </span>
          <span>${value.qty}</span>
        </div>
      </td>
      <td>
        <div>
          ${setButton}
        </div>
      </td>
    </tr>
  `;
}

function TabelListHistory({ value, no }) {
  let status = ``;
  if (value.status == 1) {
    status = `<span class="success">Masuk</span>`;
  } else {
    status = `<span class="danger">Keluar</span>`;
  }

  return `
    <tr>
      <td>${no}</td>
      <td>${value.created_at}</td>
      <td>${value.goods_id}</td>
      <td>
        <div>
          ${status}
        </div>
      </td>
      <td>
        <div>
          <span>User :</span>
          <span>${value.user_id}</span>
        </div>
      </td>
      <td>
        <div>
          <span>Qty :</span>
          <span>${value.qty}</span>
        </div>
      </td>
    </tr>
  `;
}

function TabelTrashRestock({ no, value }) {
  return `
    <tr>
      <td>${no}</td>
      <td>${value.deleted_at}</td>
      <td>
        <span>${value.restock_code}</span>
      </td>
      <td>
          <div>
            <span>User : </span>
            <span>${value.user_id}</span>
          </div>
      </td>
      <td>
        <div>
            <span>Jumlah : </span>
            <span>${value.qty}</span>
          </div>
      </td>
      <td>
        <div>
          <form action="${siteURL}/restock/restore" method="post" id="form_restock_restore${no}">
            <input type="hidden" name="csrf_test_name" value="${csrfToken.defaultValue}">
            <input type="hidden" name="restock_code" value="${value.restock_code}">
            <button type="button" class="buttonInfo" onclick="messageConfirmation({ title: 'Restore Data Restock', text: 'Apakah yakin ingin merestore data restock?', form: 'form_restock_restore${no}' })">
              <img src="${baseURL}/assets/icons/restore-line-white-1.svg" alt="restore">
              <img src="${baseURL}/assets/icons/restore-line-blue-1.svg" alt="restore">
            </button>
          </form>
          <form action="${siteURL}/restock/delete_trash" method="post" id="form_restock_delete_trash${no}">
            <input type="hidden" name="csrf_test_name" value="${csrfToken.defaultValue}">
            <input type="hidden" name="restock_code" value="${value.restock_code}">
            <button type="button" class="buttonDanger" onclick="messageConfirmation({ title: 'Hapus Permanen', text: 'Apakah yakin ingin menghapus data restock secara permanen?', form: 'form_restock_delete_trash${no}' })">
              <img src="${baseURL}/assets/icons/trash-line-x-white-1.svg" alt="restore">
              <img src="${baseURL}/assets/icons/trash-line-x-red-1.svg" alt="restore">
            </button>
          </form>
        </div>
      </td>
    </tr>
  `;
}

function TabelTrashGoods({ no, value }) {
  return `
    <tr>
      <td>${no}</td>
      <td>${value.deleted_at}</td>
      <td>
        <span>${value.goods_code}</span>
      </td>
      <td>
          <span>${value.goods_name}</span>
      </td>
      <td>
        <div>
            <span>User : </span>
            <span>${value.users_id}</span>
          </div>
      <td>
        <div>
          <form action="${siteURL}/goods/restore" method="post" id="form_goods_restore${no}">
            <input type="hidden" name="csrf_test_name" value="${csrfToken.defaultValue}">
            <input type="hidden" name="goods_code" value="${value.goods_code}">
            <button type="button" class="buttonInfo" onclick="messageConfirmation({ title: 'Restore Data Barang', text: 'Apakah yakin ingin merestore data barang?', form: 'form_goods_restore${no}' })">
              <img src="${baseURL}/assets/icons/restore-line-white-1.svg" alt="restore">
              <img src="${baseURL}/assets/icons/restore-line-blue-1.svg" alt="restore">
            </button>
          </form>
          <form action="${siteURL}/goods/delete_trash" method="post" id="form_goods_delete_trash${no}">
            <input type="hidden" name="csrf_test_name" value="${csrfToken.defaultValue}">
            <input type="hidden" name="goods_code" value="${value.goods_code}">
            <button type="button" class="buttonDanger" onclick="messageConfirmation({ title: 'Hapus Permanen', text: 'Apakah yakin ingin menghapus data barang secara permanen?', form: 'form_goods_delete_trash${no}' })">
              <img src="${baseURL}/assets/icons/trash-line-x-white-1.svg" alt="restore">
              <img src="${baseURL}/assets/icons/trash-line-x-red-1.svg" alt="restore">
            </button>
          </form>
        </div>
      </td>
    </tr>
  `;
}
