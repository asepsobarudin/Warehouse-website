function tableGoods({no, value, restockCode}) {
  return `
    <tr>
      <td>${no}</td>
      <td>${value.goods_name}</td>
      <td>
        <span>Min : </span>
        <span>${value.goods_min_stock}</span>
      </td>
      <td>
        <span>Toko : </span>
        <span>${value.goods_stock_shop}</span>
      </td>
      <td>
        <button class="buttonInfo" onclick='addCartRestock({restock: "${restockCode}", value: ${JSON.stringify(value)}, btn: ${no} })' id="addCartRestock${no}">
          <img src="${baseURL}assets/icons/add-line-white-1.svg" alt="add-line">
          <img src="${baseURL}assets/icons/add-line-blue-1.svg" alt="add-line">
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
          <button class="buttonInfo" id="btnQty${no}" onclick="addCardRestockQty({no: ${no}, noGc:'${value.goods_code}', noRes:'${value.restock_code}'})">Set</button>
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