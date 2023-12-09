async function searchGoods({ goods }) {
  const data = {
    search: goods,
  };

  const url = `${siteURL}/goods/goods_search`;
  const result = await post({ url: url, data: data });
  if (result) {
    const listGoods = document.getElementById("list_goods");
    listGoods.innerHTML = "";
    result.goods.map((list) => {
      const option = document.createElement("option");
      option.value = list.goods_name;
      listGoods.appendChild(option);
    });
  }
}

loadData({
  text: `/goods`,
  fnc: `GoodsPageList({url: '${baseURL}/goods/goods_list'})`,
});

var noGoodsList = 0;
async function GoodsPageList({ url }) {
  tabelGoodsList.innerHTML = tableLoading({
    col: 7,
    element: ["paginate_button", "paginate_text"],
  });

  const result = await get({ url: url });

  if (result.code) {
    tabelGoodsList.innerHTML = tableError({ col: 6, code: result.code });
  }

  if (result && result.goods.length != 0) {
    var noGoodsList = (result.currentPage - 1) * result.perPage + 1;
    setTimeout((async) => {
      tabelGoodsList.innerHTML = "";
      result.goods.map(async (value) => {
        tabelGoodsList.innerHTML += TabelPageGoods({
          no: noGoodsList,
          value: value,
        });
        noGoodsList++;
      });

      const PaginateText = document.getElementById("paginate_text");
      if (result.currentPage && result.pageCount && result.totalItems) {
        PaginateText.innerHTML = `
          <span>${result.currentPage} dari ${result.pageCount} (${result.totalItems} barang)</span>
        `;
      }

      const PaginateButton = document.getElementById("paginate_button");
      if (result.backPage) {
        PaginateButton.innerHTML += `
          <button class="back" onclick="GoodsPageList({url: '${result.backPage}'})">
            Back
          </button>
        `;
      }

      if (result.pageCount >= 5) {
        for (
          i = Math.max(1, result.currentPage - 2);
          i < result.currentPage;
          i++
        ) {
          if (i <= result.pageCount) {
            PaginateButton.innerHTML += `
              <button class="number" onclick="GoodsPageList({url: '${siteURL}/goods/goods_list?page=${i}'})">
                ${i}
              </button>
            `;
          }
        }

        for (
          i = result.currentPage + 1;
          i <= Math.min(result.pageCount, result.currentPage + 3);
          i++
        ) {
          PaginateButton.innerHTML += `
            <button class="number" onclick="GoodsPageList({url: '${siteURL}/goods/goods_list?page=${i}'})">
              ${i}
            </button>
          `;
        }
      }

      if (result.nextPage) {
        PaginateButton.innerHTML += `
          <button class="back" onclick="GoodsPageList({url: '${result.nextPage}'})">
            Next
          </button>
        `;
      }
    }, result);
  } else {
    tabelGoodsList.innerHTML = `
    <tr>
      <td colspan="7" >
        <div class="table_loading">
          <h2>Tidak Ada Barang</h2>
        </div>
      </td>
    </tr>
    `;
  }
}

async function GoodsSearchList({ url }) {
  tabelGoodsList.innerHTML = tableLoading({
    col: 6,
    element: ["paginate_button", "paginate_text"],
  });

  const key = document.getElementById("search");
  const btnSearch = document.getElementById("button_search");
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
        tabelGoodsList.innerHTML = "";
        var no = 1;
        result.goods.map(async (value) => {
          tabelGoodsList.innerHTML += TabelPageGoods({
            no: no,
            value: value,
          });
          no++;
        });
      }, result);
    } else {
      key.disabled = false;
      btnSearch.disabled = false;
      tabelGoodsList.innerHTML = `
        <tr>
          <td colspan="7" >
            <div class="table_loading">
              <h2>Barang tidak ditemukan!</h2>
            </div>
          </td>
        </tr>
        `;
    }
  } else {
    key.disabled = false;
    btnSearch.disabled = false;
    GoodsPageList({ url: `${baseURL}/goods/goods_list` });
  }
}

loadData({
  text: `/history`,
  fnc: `GoodsHistoryList({url: '${baseURL}/history/history_list'})`,
});

var noGoodsList = 0;
async function GoodsHistoryList({ url }) {
  tabelGoodsHistory.innerHTML = tableLoading({
    col: 7,
    element: ["paginate_button", "paginate_text"],
  });

  const result = await get({ url: url });
  console.log(result)

  if (result.code) {
    tabelGoodsHistory.innerHTML = tableError({ col: 6, code: result.code });
  }

  if (result && result.goods?.length > 0) {
    var noGoodsList = (result.currentPage - 1) * result.perPage + 1;
    setTimeout((async) => {
      tabelGoodsHistory.innerHTML = "";
      result.goods.map(async (value) => {
        tabelGoodsHistory.innerHTML += TabelListHistory({
          no: noGoodsList,
          value: value,
        });
        noGoodsList++;
      });

      const PaginateText = document.getElementById("paginate_text");
      if (result.currentPage && result.pageCount && result.totalItems) {
        PaginateText.innerHTML = `
          <span>${result.currentPage} dari ${result.pageCount} (${result.totalItems} barang)</span>
        `;
      }

      const PaginateButton = document.getElementById("paginate_button");
      if (result.backPage) {
        PaginateButton.innerHTML += `
          <button class="back" onclick="GoodsHistoryList({url: '${result.backPage}'})">
            Back
          </button>
        `;
      }
      if (result.pageCount >= 5) {
        for (
          i = Math.max(1, result.currentPage - 5);
          i < result.currentPage;
          i++
        ) {
          PaginateButton.innerHTML += `
              <button class="number" onclick="GoodsHistoryList({url: '${siteURL}/goods/goods_list?page=${i}'})">
                ${i}
              </button>
            `;
        }

        for (i = result.currentPage; i <= result.pageCount; i++) {
          if (result.currentPage != i) {
            PaginateButton.innerHTML += `
              <button class="number" onclick="GoodsHistoryList({url: '${siteURL}/goods/goods_list?page=${i}'})">
                ${i}
              </button>
            `;
          }
        }
      }

      if (result.nextPage) {
        PaginateButton.innerHTML += `
          <button class="back" onclick="GoodsHistoryList({url: '${result.nextPage}'})">
            Next
          </button>
        `;
      }
    }, result);
  } else {
    tabelGoodsHistory.innerHTML = `
    <tr>
      <td colspan="7" >
        <div class="table_loading">
          <h2>Tidak Ada Barang</h2>
        </div>
      </td>
    </tr>
    `;
  }
}

async function DateHistoryList() {
  const getDate = document.getElementById("input-date");
  if (getDate.value.length > 0) {
    const url = `${siteURL}/history/history_date`;
    const data = {
      search: getDate.value,
    };

    tabelGoodsHistory.innerHTML = tableLoading({
      col: 7,
      element: ["paginate_button", "paginate_text"],
    });

    const result = await post({ url: url, data: data });

    if (result && result.goods?.length > 0) {
      tabelGoodsHistory.innerHTML = "";
      setTimeout((async) => {
        result.goods.map(async (value) => {
          tabelGoodsHistory.innerHTML += TabelListHistory({
            no: noGoodsList,
            value: value,
          });
          noGoodsList++;
        });
      }, result);
    } else {
      tabelGoodsHistory.innerHTML = `
      <tr>
        <td colspan="7" >
          <div class="table_loading">
            <h2>Tidak Ada History</h2>
          </div>
        </td>
      </tr>
      `;
    }
  }
}

loadData({
  text: `/trash`,
  fnc: `RestockTrashList({url: '${baseURL}/restock/trash'})`,
});

async function RestockTrashList({ url }) {
  tabelTrashRestock.innerHTML = tableLoading({
    col: 6,
    element: null,
  });

  const result = await get({ url: url });
  tabelTrashRestock.innerHTML = "";

  setTimeout((async) => {
    if (result && result.restock.length > 0) {
      let no = 1;
      result.restock.map((list) => {
        tabelTrashRestock.innerHTML += TabelTrashRestock({
          no: no,
          value: list,
        });
        no++;
      });
    } else {
      tabelTrashRestock.innerHTML = `
      <tr>
        <td colspan="6" >
          <div class="table_loading">
            <h2>Tidak Ada Restock</h2>
          </div>
        </td>
      </tr>
      `;
    }
  }, result);
}

async function GoodsTrashList({ url }) {
  tabelTrashGoods.innerHTML = tableLoading({
    col: 6,
    element: null,
  });

  const result = await get({ url: url });
  tabelTrashGoods.innerHTML = "";

  setTimeout((async) => {
    if (result && result.goods.length > 0) {
      let no = 1;
      result.goods.map((list) => {
        tabelTrashGoods.innerHTML += TabelTrashGoods({
          no: no,
          value: list,
        });
        no++;
      });
    } else {
      tabelTrashGoods.innerHTML = `
      <tr>
        <td colspan="6" >
          <div class="table_loading">
            <h2>Tidak Ada Barang</h2>
          </div>
        </td>
      </tr>
      `;
    }
  }, result);
}
