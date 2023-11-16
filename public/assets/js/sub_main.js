async function postRestock({ restock, goods, btn }) {
  const data = {
    restock: restock,
    goods: goods,
    qty: null,
  };
  const btnLoading = document.getElementById(`buttonAddGoodsRestock${btn}`);
  btnLoading.disabled = true;

  const url = `${baseURL}restock/add_goods`;
  const result = await post({ url: url, data: data });

  if (result.success) {
    var notif = {
      title: result.success,
    };
    btnLoading.disabled = false;
    notification({ notif: notif });
  }

  if (result.errors) {
    var notif = {
      title: result.errors,
    };
    btnLoading.disabled = false;
    notification({ notif: notif });
  }

  if (result.data) {
    const btnRestock = document.getElementById("restockButton");
    if (!btnRestock.chacked) {
      btnRestock.checked = true;
      openCart();
    }

    document.getElementById("restock_list_cart").innerHTML = "";
    var no = 1;
    result.data.map((value) => {
      const restockList = document.getElementById("restock_list_cart");
      restockList.innerHTML += cardRestock({
        no: no,
        title: value.goods_name,
        qty: value.qty,
        noGc: value.goods_code,
        noRes: value.restock_code,
      });
      no++;
    });
  }
}

async function removeRestock({ restock, goods, btn }) {
  const data = {
    restock: restock,
    goods: goods,
  };

  const btnDelete = document.getElementById(`buttonDelete${btn}`);
  btnDelete.disabled = true;

  const url = `${baseURL}restock/rs_delete`;
  const result = await post({ url: url, data: data });
  if (result.success) {
    var notif = {
      title: result.success,
    };
    btnDelete.disabled = false;
    notification({ notif: notif });
    listRestock({ restock: restock });
  }
  if (result.errors) {
    var notif = {
      title: result.errors,
    };
    btnDelete.disabled = false;
    notification({ notif: notif });
  }
}

async function addQty({ qty, btn, noGc, noRes }) {
  const getQty = document.getElementById(`qty${qty}`);
  const getBtnQty = document.getElementById(`btnQty${btn}`);
  const data = {
    restock: noRes,
    goods: noGc,
    qty: getQty.value,
  };

  getQty.disabled = true;
  getBtnQty.disabled = true;

  const url = `${baseURL}restock/add_qty`;
  const result = await post({ url: url, data: data });

  if (result.success) {
    var notif = {
      title: result.success,
    };
    getQty.disabled = false;
    getBtnQty.disabled = false;
    notification({ notif: notif });
    listRestock({ restock: restockCode });
  }

  if (result.errors) {
    var notif = {
      title: result.errors,
    };
    getQty.disabled = false;
    getBtnQty.disabled = false;
    notification({ notif: notif });
  }
}

loadData({
  text: "restock_edit/",
  fnc: `listRestock({ restock: '${restockCode}' })`,
});

async function listRestock({ restock }) {
  const data = {
    restock: restock,
  };
  const url = `${baseURL}restock/list_goods`;
  const result = await post({
    url: url,
    data: data,
  });

  if (result.data) {
    const btnRestock = document.getElementById("restockButton");
    if (!btnRestock.chacked) {
      btnRestock.checked = true;
      openCart();
    }

    document.getElementById("restock_list_cart").innerHTML = "";
    var no = 1;
    result.data.map((value) => {
      const restockList = document.getElementById("restock_list_cart");
      restockList.innerHTML += cardRestock({
        no: no,
        title: value.goods_name,
        qty: value.qty,
        noGc: value.goods_code,
        noRes: value.restock_code,
      });
      no++;
    });
  }
}

loadData({
  text: "restock_create",
  fnc: `getGoods({url: '${baseURL}goods/goods_list'})`,
});

loadData({
  text: "restock_edit",
  fnc: `getGoods({url: '${baseURL}goods/goods_list'})`,
});

async function getGoods({ url }) {
  rsTable.innerHTML = tableLoading({
    col: 6,
    element: ["paginate_button", "paginate_text"],
  });
  const result = await get({ url: url });

  if (result.code) {
    rsTable.innerHTML = tableError({ col: 5, code: result.code });
  }

  if (result && result.goods.length != 0) {
    setTimeout((async) => {
      rsTable.innerHTML = "";
      paginateBtn({ data: result, table: rsTable, col: 6 });
      var no = 1;
      result.goods.map(async (value) => {
        rsTable.innerHTML += tableGoods({
          no: no,
          name: value.goods_name,
          min: value.goods_min_stock,
          stokToko: value.goods_stock_shop,
          stokGudang: value.goods_stock_warehouse,
          restockCode: restockCode,
          goodsCode: value.goods_code,
        });
        no++;
      });
    }, 1000);
  } else {
    rsTable.innerHTML = `
    <tr>
      <td colspan="6" >
        <div class="tbLoading">
          <h2>Tidak Ada Barang</h2>
        </div>
      </td>
    </tr>
    `;
  }
}

async function csSearch({ url }) {
  rsTable.innerHTML = tableLoading({
    col: 6,
    element: ["paginate_button", "paginate_text"],
  });
  const key = document.getElementById("cs_input_search");
  const btnSearch = document.getElementById("btn_search");
  key.disabled = true;
  btnSearch.disabled = true;
  const data = { search: key.value };

  if (key.value) {
    const result = await post({ url: url, data: data });
    if (result && result.goods.length != 0 && result.goods.currentRow != 0) {
      setTimeout(() => {
        key.disabled = false;
        btnSearch.disabled = false;
        rsTable.innerHTML = "";
        paginateBtn({ data: result, table: rsTable, col: 6 });
        var no = 1;
        result.goods.map(async (value) => {
          rsTable.innerHTML += tableGoods({
            no: no,
            name: value.goods_name,
            min: value.goods_min_stock,
            stokToko: value.goods_stock_shop,
            stokGudang: value.goods_stock_warehouse,
            restockCode: restockCode,
            goodsCode: value.goods_code,
          });
          no++;
        });
      }, 1000);
    } else {
      key.disabled = false;
      btnSearch.disabled = false;
      rsTable.innerHTML = `
        <tr>
          <td colspan="6" >
            <div class="tbLoading">
              <h2>Barang tidak ditemukan!</h2>
            </div>
          </td>
        </tr>
        `;
    }
  } else {
    getGoods({ url: `${baseURL}goods/goods_list` });
  }
}

function cardRestock({ no, title, qty, noGc, noRes }) {
  return `
    <div class="cart_restock">
      <div>
        <h2>${no}.</h2>
        <h2>${title}</h2>
      </div>
      <div>
        <button class="buttonDanger" id="buttonDelete${no}" onclick="removeRestock({ restock: '${noRes}', goods: '${noGc}', btn: ${no} })">
          <img src="${baseURL}assets/icons/trash-line-white-1.svg" alt="trash-line">
          <img src="${baseURL}assets/icons/trash-line-red-1.svg" alt="trash-line">
        </button>
        <label for="qty">
          <input type="number" id="qty${no}" value="${qty}" onchange="addQty({qty: ${no}, btn: ${no}, noGc:'${noGc}', noRes:'${noRes}'})">
          <button class="buttonInfo" id="btnQty${no}" onclick="addQty({qty: ${no}, btn: ${no}, noGc:'${noGc}', noRes:'${noRes}'})">Set</button>
        </label>
      </div>
    </div>
  `;
}

function tableGoods({
  no,
  name,
  min,
  stokToko,
  stokGudang,
  restockCode,
  goodsCode,
}) {
  return `
    <tr>
      <td>${no}</td>
      <td>${name}</td>
      <td>
        <span>Min : </span>
        <span>${min}</span>
      </td>
      <td>
        <span>Toko : </span>
        <span>${stokToko}</span>
      </td>
      <td>
        <span>Toko : </span>
        <span>${stokGudang}</span>
      </td>
      <td>
        <button class="buttonInfo" onclick="postRestock({restock: '${restockCode}', goods: '${goodsCode}', btn: ${no} })" id="buttonAddGoodsRestock${no}">
          <img src="${baseURL}assets/icons/add-line-white-1.svg" alt="add-line">
          <img src="${baseURL}assets/icons/add-line-blue-1.svg" alt="add-line">
          <h2>Add</h2>
        </button>
      </td>
    </tr>
  `;
}

loadData({
  text: "get_restock",
  fnc: `getListRestock()`,
});

async function getListRestock() {
  const data = {
    restock: restockCode,
  };
  const url = `${baseURL}distribution/restock_list`;
  const result = await post({ url: url, data: data });
  if (result.data) {
    dsTable.innerHTML = "";
    var no = 1;
    result.data.map(async (value) => {
      dsTable.innerHTML += listGoodsRestock({
        no: no,
        goodsName: value.goods_name,
        qty: value.qty,
        stockWarehouse: value.goods_stock_warehouse,
        qtyAdd: value.qty_response,
        goodsCode: value.goods_code,
      });
      no++;
    });
  }

  if (result.errors) {
    var notif = {
      title: result.errors,
    };
    notification({ notif: notif });
  }
}

async function addQtyResponse({ itemInput, goods, oprator }) {
  const addValue = document.getElementById(itemInput).value;
  const btnPlush = document.getElementById("btnPlush");
  const btnMinus = document.getElementById("btnMinus");

  if(addValue != 0){
    btnPlush.disabled = true;
    btnMinus.disabled = true;
  }

  if (addValue && addValue > 0) {
    const url = `${baseURL}distribution/add_items`;
    const data = {
      restock: restockCode,
      goods: goods,
      qtyItems: addValue,
      oprator: oprator,
    };

    const result = await post({ url: url, data: data });
    if (result.success) {
      var notif = {
        title: result.success,
      };
      notification({ notif: notif });
      getListRestock();
      btnPlush.disabled = false;
      btnMinus.disabled = false;
    }

    if (result.errors) {
      var notif = {
        title: result.errors,
      };
      notification({ notif: notif });
      btnPlush.disabled = false;
      btnMinus.disabled = false;
    }
  }
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
  var setButton = "";

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
      <td>
        <div>
          <span>Stok : </span>
          <span class='${status}'>${stockWarehouse}</span>
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
          <button class="buttonDanger" id="btnMinus" onclick="addQtyResponse({itemInput: 'inputQty${no}', goods: '${goodsCode}', oprator: 'minus'})">
            <img src="${baseURL}assets/icons/minus-line-white-1.svg" alt="minus-line" />
            <img src="${baseURL}assets/icons/minus-line-red-1.svg" alt="minus-line" />
          </button>
          <input type="number" id="inputQty${no}" value="${qtyAdd}">
          <button class="buttonInfo" id="btnPlush" onclick="addQtyResponse({itemInput: 'inputQty${no}', goods: '${goodsCode}', oprator: 'plus'})">
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
