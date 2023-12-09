// Restock
async function addCartRestock({ restock, goods, btn }) {
  const btnLoading = document.getElementById(`addCartRestock${btn}`);
  btnLoading.disabled = true;
  const data = {
    restock: restock,
    goods: goods,
    qty: null,
  };

  if (data && data.restock && data.goods) {
    const url = `${siteURL}/restock/add_goods`;
    const result = await post({ url: url, data: data });

    if (result.success) {
      var notif = {
        title: result.success,
      };
      btnLoading.disabled = false;
      notification({ notif: notif, status: 1 });
      listRestock({ restock: result.restock });
      const key = document.getElementById("input_search");
      if (key.value != "") {
        SEARCH({ url: `${siteURL}/goods/goods_search` });
      } else {
        GET({ url: `${siteURL}/goods/goods_list` });
      }
    }

    if (result.errors) {
      var notif = {
        title: result.errors,
      };
      btnLoading.disabled = false;
      notification({ notif: notif, status: 0 });
    }
  } else {
    var notif = {
      title: "Data barang gagal ditambahkan!",
    };
    btnLoading.disabled = false;
    notification({ notif: notif, status: 0 });
  }
}

async function removeCartRestock({ restock, goods, no }) {
  const data = {
    restock: restock,
    goods: goods,
  };

  const btnDelete = document.getElementById(`buttonDelete${no}`);
  btnDelete.disabled = true;

  const url = `${siteURL}/restock/delete_goods`;
  const result = await post({ url: url, data: data });

  if (result.success && result.load == 1) {
    GET({ url: `${siteURL}/goods/goods_list` });
  }

  if (result.success) {
    var notif = {
      title: result.success,
    };
    btnDelete.disabled = false;
    notification({ notif: notif, status: 1 });
    listRestock({ restock: restock });
  }
  if (result.errors) {
    var notif = {
      title: result.errors,
    };
    btnDelete.disabled = false;
    notification({ notif: notif, status: 0 });
  }
}

async function addCardRestockQty({ no, goods, restock }) {
  const getQty = document.getElementById(`qty${no}`);
  const getBtnQty = document.getElementById(`btnQty${no}`);
  getBtnQty.disabled = true;

  const data = {
    restock: restock,
    goods: goods,
    qty: getQty.value,
  };

  const url = `${siteURL}/restock/add_qty`;
  const result = await post({ url: url, data: data });

  if (result.success) {
    var notif = {
      title: result.success,
    };
    getBtnQty.disabled = false;
    notification({ notif: notif, status: 1 });
    listRestock({ restock: restockCode });
    const key = document.getElementById("input_search");
    if (key.value != "") {
      SEARCH({ url: `${siteURL}/goods/goods_search` });
    } else {
      GET({ url: `${siteURL}/goods/goods_list` });
    }
  }

  if (result.errors) {
    var notif = {
      title: result.errors,
    };
    getBtnQty.disabled = false;
    notification({ notif: notif, status: 0 });
  }
}

loadData({
  text: `/restock/edit/`,
  fnc: `listRestock({ restock: '${restockCode}' })`,
});

async function listRestock({ restock }) {
  const data = {
    restock: restock,
  };
  const url = `${siteURL}/restock/list_goods`;
  const result = await post({
    url: url,
    data: data,
  });

  if (result.errors) {
    var notif = {
      title: result.errors,
    };
    notification({ notif: notif, status: 0 });
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
  text: `/restock/create`,
  fnc: `GET({url: '${siteURL}/goods/goods_list'})`,
});

loadData({
  text: `/restock/edit/`,
  fnc: `GET({url: '${siteURL}/goods/goods_list'})`,
});

async function GET({ url }) {
  const goodsTable = document.getElementById("goods_table");
  goodsTable.innerHTML = tableLoading({
    col: 5,
    element: ["paginate_button", "paginate_text"],
  });
  const result = await get({ url: url });

  if (result.code) {
    goodsTable.innerHTML = tableError({ col: 6, code: result.code });
  }

  if (result && result.goods.length != 0) {
    setTimeout((async) => {
      goodsTable.innerHTML = "";
      const btnBack = document.getElementById("paginate_button");
      const textPaginate = document.getElementById("paginate_text");
      if (result.backPage) {
        btnBack.innerHTML += `<button onclick="PagePaginate({ url: '${result.backPage}'})" class="back">Kembali</button>`;
      }
      if (result.nextPage) {
        btnBack.innerHTML += `<button onclick="PagePaginate({ url: '${result.nextPage}'})" class="next">Berikutnya</button>`;
      }
      if (result.totalItems >= 1) {
        textPaginate.innerHTML = `
            <span>Halaman</span>
            <span>${result.currentPage}</span>
            <span>dari</span>
            <span>${result.pageCount}</span>
            <span>(${result.totalItems} Barang)</span>
          `;
      }

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

async function SEARCH({ url }) {
  const goodsTable = document.getElementById("goods_table");
  goodsTable.innerHTML = tableLoading({
    col: 5,
    element: ["paginate_button", "paginate_text"],
  });
  const key = document.getElementById("input_search");
  const btnSearch = document.getElementById("btn_search");
  key.disabled = true;
  btnSearch.disabled = true;

  const data = {
    search: key.value,
  };

  if (key.value) {
    const result = await post({ url: url, data: data });
    console.log(result);
    if (result && result.goods.length != 0 && result.goods.currentRow != 0) {
      setTimeout(() => {
        key.disabled = false;
        btnSearch.disabled = false;
        goodsTable.innerHTML = "";

        const btnBack = document.getElementById("paginate_button");
        const textPaginate = document.getElementById("paginate_text");
        if (result.backPage) {
          btnBack.innerHTML += `<button onclick="PagePaginate({ url: '${result.backPage}'})" class="back">Kembali</button>`;
        }
        if (result.nextPage) {
          btnBack.innerHTML += `<button onclick="PagePaginate({ url: '${result.nextPage}'})" class="next">Berikutnya</button>`;
        }
        if (result.totalItems >= 1) {
          textPaginate.innerHTML = `
            <span>Halaman</span>
            <span>${result.currentPage}</span>
            <span>dari</span>
            <span>${result.pageCount}</span>
            <span>(${result.totalItems} Barang)</span>
          `;
        }

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
    GET({ url: `${siteURL}/goods/goods_list` });
  }
}

function PagePaginate({ url }) {
  GET({ url: url });
  backToTop({ element: containerPage });
}
