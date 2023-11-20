// Restock
async function addCartRestock({ restock, value, btn }) {
  const btnLoading = document.getElementById(`addCartRestock${btn}`);
  btnLoading.disabled = true;
  const data = {
    restock: restock,
    goods: value.goods_code,
    qty: null,
  };

  if (data && data.restock && data.goods) {
    const url = `${baseURL}restock/add_goods`;
    const result = await post({ url: url, data: data });

    if (result.success) {
      var notif = {
        title: result.success,
      };
      btnLoading.disabled = false;
      notification({ notif: notif });
      listRestock({ restock: result.restock });
    }

    if (result.errors) {
      var notif = {
        title: result.errors,
      };
      btnLoading.disabled = false;
      notification({ notif: notif });
    }
  } else {
    var notif = {
      title: "Data barang gagal ditambahkan!",
    };
    btnLoading.disabled = false;
    notification({ notif: notif });
  }
}

async function removeCartRestock({ restock, goods, no }) {
  const data = {
    restock: restock,
    goods: goods,
  };

  const btnDelete = document.getElementById(`buttonDelete${no}`);
  btnDelete.disabled = true;

  const url = `${baseURL}restock/delete_goods`;
  const result = await post({ url: url, data: data });

  if (result.success && result.load == 1) {
    goodsList({ url: `${baseURL}goods/goods_list` });
  }

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

async function addCardRestockQty({ no, noGc, noRes }) {
  const getQty = document.getElementById(`qty${no}`);
  const getBtnQty = document.getElementById(`btnQty${no}`);
  getBtnQty.disabled = true;

  const data = {
    restock: noRes,
    goods: noGc,
    qty: getQty.value,
  };

  const url = `${baseURL}restock/add_qty`;
  const result = await post({ url: url, data: data });

  if (result.success) {
    var notif = {
      title: result.success,
    };
    getBtnQty.disabled = false;
    notification({ notif: notif });
    listRestock({ restock: restockCode });
  }

  if (result.errors) {
    var notif = {
      title: result.errors,
    };
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

  if (result.errors) {
    var notif = {
      title: result.errors,
    };
    notification({ notif: notif });
  }

  if (result.data) {
    const btnRestock = document.getElementById("restockButton");
    if (!btnRestock.chacked) {
      btnRestock.checked = true;
      openCart();
    }

    if (result) {
      setTimeout(() => {
        document.getElementById("restock_list_cart").innerHTML = "";
        var no = 1;
        result.data.map((value) => {
          const restockList = document.getElementById("restock_list_cart");
          restockList.innerHTML += cardCartCardRestock({
            no: no,
            value: value,
          });
          no++;
        });
      }, result);
    } else {
      document.getElementById("restock_list_cart").innerHTML =
        "List Tidak Ditemukan";
    }
  }
}

loadData({
  text: "restock_create",
  fnc: `goodsList({url: '${baseURL}goods/goods_list'})`,
});

loadData({
  text: "restock_edit",
  fnc: `goodsList({url: '${baseURL}goods/goods_list'})`,
});

async function goodsList({ url }) {
  goodsTable.innerHTML = tableLoading({
    col: 6,
    element: ["paginate_button", "paginate_text"],
  });
  const result = await get({ url: url });

  if (result.code) {
    goodsTable.innerHTML = tableError({ col: 6, code: result.code });
  }

  if (result && result.goods.length != 0) {
    setTimeout((async) => {
      goodsTable.innerHTML = "";
      paginateBtn({ data: result, table: goodsTable, col: 6 });
      var no = 1;
      result.goods.map(async (value) => {
        goodsTable.innerHTML += tableGoods({
          no: no,
          value: value,
          restockCode: restockCode,
        });
        no++;
      });
    }, result);
  } else {
    goodsTable.innerHTML = `
    <tr>
      <td colspan="6" >
        <div class="table_loading">
          <h2>Tidak Ada Barang</h2>
        </div>
      </td>
    </tr>
    `;
  }
}

async function goodsSearch({ url }) {
  goodsTable.innerHTML = tableLoading({
    col: 6,
    element: ["paginate_button", "paginate_text"],
  });
  const key = document.getElementById("goods_input_search");
  const btnSearch = document.getElementById("btn_search");
  key.disabled = true;
  btnSearch.disabled = true;

  const data = {
    search: key.value,
  };

  if (key.value) {
    const result = await post({ url: url, data: data });
    if (result && result.goods.length != 0 && result.goods.currentRow != 0) {
      setTimeout(() => {
        key.disabled = false;
        btnSearch.disabled = false;
        goodsTable.innerHTML = "";
        paginateBtn({ data: result, table: goodsTable, col: 6 });
        var no = 1;
        result.goods.map(async (value) => {
          goodsTable.innerHTML += tableGoods({
            no: no,
            value: value,
            restockCode: restockCode,
          });
          no++;
        });
      }, result);
    } else {
      key.disabled = false;
      btnSearch.disabled = false;
      goodsTable.innerHTML = `
        <tr>
          <td colspan="6" >
            <div class="table_loading">
              <h2>Barang tidak ditemukan!</h2>
            </div>
          </td>
        </tr>
        `;
    }
  } else {
    goodsList({ url: `${baseURL}goods/goods_list` });
  }
}

// Distribution
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
        qtyAdd: value.qty_send,
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

async function addDistributionQty({ itemInput, goods, oprator, btn, no }) {
  const addValue = document.getElementById(itemInput).value;
  const btnLoading = document.getElementById(`${btn + no}`);

  var getValue = 0;
  getValue = parseInt(addValue);

  if (getValue && getValue > 0) {
    const url = `${baseURL}distribution/add_send`;
    const data = {
      restock: restockCode,
      goods: goods,
      qtyItems: getValue,
      oprator: oprator,
    };

    const result = await post({ url: url, data: data });
    btnLoading.innerHTML = `<img src="${baseURL}assets/icons/loading-line-white-1.svg" alt="loading-line" class="loading" />`;

    setTimeout(() => {
      if (result.success) {
        var notif = {
          title: result.success,
        };
        notification({ notif: notif });
        getListRestock();
      }

      if (result.errors) {
        var notif = {
          title: result.errors,
        };
        notification({ notif: notif });

        if (btn == "btnPlush") {
          btnLoading.innerHTML = `
            <img src="${baseURL}assets/icons/plus-line-white-1.svg" alt="plus-line" />
            <img src="${baseURL}assets/icons/plus-line-blue-1.svg" alt="plus-line" />
          `;
        } else {
          btnLoading.innerHTML = `
            <img src="${baseURL}assets/icons/minus-line-white-1.svg" alt="minus-line" />
            <img src="${baseURL}assets/icons/minus-line-red-1.svg" alt="minus-line" />
          `;
        }
      }
    }, result);
  } else {
    var notif = {
      title: "Silahkan tambahkan jumlah barang!",
    };
    notification({ notif: notif });
  }
}
