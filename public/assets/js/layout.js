function tableGoods({ no, value, restockCode }) {
  return `
    <tr>
      <td>${no}</td>
      <td>${value.goods_name}</td>
      <td>
        <span>Min : </span>
        <span>${value.goods_min_stock}</span>
      </td>
      <td>
        <span>Gudang : </span>
        <span>${value.goods_stock_warehouse}</span>
      </td>
      <td>
        <button class="buttonInfo" onclick="addCartRestock({restock: '${restockCode}', goods: '${value.goods_code}', btn: ${no} })" id="addCartRestock${no}">
          <img src="${baseURL}assets/icons/cart-line-plus-white-1.svg" alt="add-line">
          <img src="${baseURL}assets/icons/cart-line-plus-blue-1.svg" alt="add-line">
          <h2>Tambahkan</h2>
        </button>
      </td>
    </tr>
  `;
}

function cardCartCardRestock({ no, value }) {
  return `
    <div class="card_cart_restock">
      <div>
        <h2>${no}.</h2>
        <h2>${value.goods_name}</h2>
      </div>
      <div>
        <button class="buttonDanger" id="buttonDelete${no}" onclick="removeCartRestock({ restock: '${value.restock_code}', goods: '${value.goods_code}', no: ${no} })">
          <img src="${baseURL}assets/icons/trash-line-white-1.svg" alt="trash-line">
          <img src="${baseURL}assets/icons/trash-line-red-1.svg" alt="trash-line">
        </button>
        <label for="qty">
          <input type="number" id="qty${no}" value="${value.qty}">
          <button class="buttonInfo" id="btnQty${no}" onclick="addCardRestockQty({no: ${no}, goods:'${value.goods_code}', restock:'${value.restock_code}'})">Set</button>
        </label>
      </div>
    </div>
  `;
}

function listGoodsRestock({
  no,
  goodsName,
  stockWarehouse,
  qty,
  qtyAdd,
  goodsCode,
}) {
  var setComplate = "";

  if (qtyAdd == null) {
    qtyAdd = 0;
  }

  if (qty == qtyAdd) {
    setComplate = `<img src="${baseURL}assets/icons/check-line-black-1.svg" alt="check">`;
  } else if (qty > qtyAdd) {
    var percent = (qtyAdd / qty) * 100;
    var setPercent = Math.floor(percent);
    setComplate = `${setPercent}%`;
  } else {
    var percent = (qtyAdd / qty) * 100;
    var setPercent = Math.floor(percent);
    setComplate = `${setPercent}%`;
  }

  var status = "";
  if (stockWarehouse < qty) {
    status = "low";
  } else {
    status = "high";
  }

  return `
    <tr>
      <td>${no}</td>
      <td>${goodsName}</td>
      <td class='${status}'>
        <div>
          <span>Stok Gudang : </span>
          <span>${stockWarehouse}</span>
        </div>
      </td>
      <td>
        <div>
          <span>Permintaan : </span>
          <span>${qty}</span>
        </div>
      </td>
      <td>
        <div>
          <span>Jumlah Kirim: </span>
          <span>${qtyAdd}</span>
        </div>
      </td>
      <td>
        <div>
          <button class="buttonDanger" id="btnMinus${no}" onclick="addDistributionQty({itemInput: 'inputQty${no}', goods: '${goodsCode}', oprator: 'minus', btn: 'btnMinus', no: ${no}})">
            <img src="${baseURL}assets/icons/minus-line-white-1.svg" alt="minus-line" />
            <img src="${baseURL}assets/icons/minus-line-red-1.svg" alt="minus-line" />
          </button>
          <input type="number" id="inputQty${no}" placeholder="Qty">
          <button class="buttonInfo" id="btnPlush${no}" onclick="addDistributionQty({itemInput: 'inputQty${no}', goods: '${goodsCode}', oprator: 'plus', btn: 'btnPlush', no: ${no}})">
            <img src="${baseURL}assets/icons/plus-line-white-1.svg" alt="plus-line" />
            <img src="${baseURL}assets/icons/plus-line-blue-1.svg" alt="plus-line" />
          </button>
        </div>
      </td>
      <td>
        <span>
          ${setComplate}  
        </span>
      </td>
    </tr>
  `;
}

function TabelPageGoods({ value, no }) {
  const number = parseInt(value.goods_price);
  const fixedNumber = number.toFixed(0);
  const numberWithCommas = fixedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  const goodsCode = value.goods_code;
  var code = goodsCode.substring(0, 5) + "...";

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
          <span>Minimal : </span>
          <span>${value.goods_min_stock}</span>
        </div>
      </td>
      <td>
        <div>
          <span>Stok : </span>
          <span>${value.goods_stock_warehouse}</span>
        </div>
      </td>
      <td>
        <div>
          <a href="${siteURL}/goods/edit/${value.goods_code}" class="buttonInfo">
            <img src="${baseURL}/assets/icons/details-line-white-1.svg" alt="eye">
            <img src="${baseURL}/assets/icons/details-line-blue-1.svg" alt="eye">
            <h2>Detail</h2>
          </a>
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

  let button = ``;
  if (value.status == 1) {
    button = `
      <button class="buttonDanger">
        <img src="${baseURL}/assets/icons/trash-line-white-1.svg" alt="save">
        <img src="${baseURL}/assets/icons/trash-line-red-1.svg" alt="save">
        <h2>Hapus</h2>
      </button>
    `;
  } else {
    button = `
      <a href="${siteURL}/restock/details/${value.restock_code}" class="buttonInfo">
        <img src="${baseURL}/assets/icons/details-line-white-1.svg" alt="details-line">
        <img src="${baseURL}/assets/icons/details-line-blue-1.svg" alt="details-line">
        <h2>Details</h2>
      </a>
    `;
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
      <td>
        <div>
          ${button}
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
        ${value.restock_code}
      </td>
      <td>
          <span>${value.user_id}</span>
      </td>
      <td>${value.qty}</td>
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
        ${value.goods_code}
      </td>
      <td>
          <span>${value.goods_name}</span>
      </td>
      <td>${value.users_id}</td>
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