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

async function GoodsPageList({ url }) {
  backToTop();
  tabelGoodsList.innerHTML = tableLoading({
    col: 7,
    element: ["paginate_button", "paginate_text"],
  });
  const result = await get({ url: url });

  if (result.code) {
    tabelGoodsList.innerHTML = tableError({ col: 6, code: result.code });
  }

  setTimeout((async) => {
    if (result && result.goods.length != 0) {
      var noList = (result.currentPage - 1) * result.perPage + 1;
      tabelGoodsList.innerHTML = "";
      result.goods.map(async (value) => {
        tabelGoodsList.innerHTML += TabelPageGoods({
          no: noList,
          value: value,
        });
        noList++;
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
    } else {
      tabelGoodsList.innerHTML = `
      <tr>
        <td colspan="6">
          <div class="table_loading">
              <img src="${baseURL}/assets/icons/not-line-black-1.svg" alt="not-line">

          </div>
        </td>
      </tr>
      `;
    }
  }, result);
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
              <img src="${baseURL}/assets/icons/not-line-black-1.svg" alt="not-line">

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
  text: `/restock`,
  fnc: `RestockPageList({url: '${baseURL}/restock/restock_list'})`,
});

async function RestockPageList({ url }) {
  backToTop();
  tabelRestockList.innerHTML = tableLoading({
    col: 7,
    element: ["paginate_button", "paginate_text"],
  });
  const result = await get({ url: url });

  if (result.code) {
    tabelRestockList.innerHTML = tableError({ col: 6, code: result.code });
  }

  setTimeout((async) => {
    if (result && result.restock.length != 0) {
      var noList = (result.currentPage - 1) * result.perPage + 1;
      tabelRestockList.innerHTML = "";
      result.restock.map(async (value) => {
        tabelRestockList.innerHTML += TabelPageRestock({
          no: noList,
          value: value,
        });
        noList++;
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
        <button class="back" onclick="RestockPageList({url: '${result.backPage}'})">
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
            <button class="number" onclick="RestockPageList({url: '${siteURL}/goods/goods_list?page=${i}'})">
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
          <button class="number" onclick="RestockPageList({url: '${siteURL}/goods/goods_list?page=${i}'})">
            ${i}
          </button>
        `;
        }
      }

      if (result.nextPage) {
        PaginateButton.innerHTML += `
        <button class="back" onclick="RestockPageList({url: '${result.nextPage}'})">
          Next
        </button>
      `;
      }
    } else {
      tabelRestockList.innerHTML = `
      <tr>
        <td colspan="7">
          <div class="table_loading">
            <img src="${baseURL}/assets/icons/not-line-black-1.svg" alt="not-line">
          </div>
        </td>
      </tr>
      `;
    }
  }, result);
}

loadData({
  text: `/history`,
  fnc: `GoodsHistoryList({url: '${baseURL}/history/history_list'})`,
});

async function GoodsHistoryList({ url }) {
  tabelGoodsHistory.innerHTML = tableLoading({
    col: 7,
    element: ["paginate_button", "paginate_text"],
  });

  const result = await get({ url: url });

  if (result.code) {
    tabelGoodsHistory.innerHTML = tableError({ col: 6, code: result.code });
  }

  if (result && result.goods?.length > 0) {
    var noList = (result.currentPage - 1) * result.perPage + 1;
    setTimeout((async) => {
      tabelGoodsHistory.innerHTML = "";
      result.goods.map(async (value) => {
        tabelGoodsHistory.innerHTML += TabelListHistory({
          no: noList,
          value: value,
        });
        noList++;
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
          <img src="${baseURL}/assets/icons/not-line-black-1.svg" alt="not-line"
        </div>
      </td>
    </tr>
    `;
  }
}

async function DateRestockList() {
  const getDate = document.getElementById("input-date");
  if (getDate.value.length > 0) {
    const url = `${siteURL}/restock/restock_date`;
    const data = {
      search: getDate.value,
    };

    tabelRestockList.innerHTML = tableLoading({
      col: 7,
      element: ["paginate_button", "paginate_text"],
    });

    const result = await post({ url: url, data: data });

    if (result && result.restock?.length > 0) {
      tabelRestockList.innerHTML = "";
      var noList = 1;
      setTimeout((async) => {
        result.restock.map(async (value) => {
          tabelRestockList.innerHTML += TabelPageRestock({
            no: noList,
            value: value,
          });
          noList++;
        });
      }, result);
    } else {
      tabelRestockList.innerHTML = `
      <tr>
        <td colspan="7" >
          <div class="table_loading">
            <img src="${baseURL}/assets/icons/not-line-black-1.svg" alt="not-line">
          </div>
        </td>
      </tr>
      `;
    }
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
      var noList = 1;
      setTimeout((async) => {
        result.goods.map(async (value) => {
          tabelGoodsHistory.innerHTML += TabelListHistory({
            no: noList,
            value: value,
          });
          noList++;
        });
      }, result);
    } else {
      tabelGoodsHistory.innerHTML = `
      <tr>
        <td colspan="7" >
          <div class="table_loading">
            <img src="${baseURL}/assets/icons/not-line-black-1.svg" alt="not-line">
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
    element: ["paginate_button_restock", "paginate_text_restock"],
  });

  const result = await get({ url: url });
  setTimeout((async) => {
    if (result && result.restock.length > 0) {
      var noList = (result.currentPage - 1) * result.perPage + 1;
      tabelTrashRestock.innerHTML = "";
      result.restock.map((list) => {
        tabelTrashRestock.innerHTML += TabelTrashRestock({
          no: noList,
          value: list,
        });
        noList++;
      });

      const PaginateText = document.getElementById("paginate_text_restock");
      if (result.currentPage && result.pageCount && result.totalItems) {
        PaginateText.innerHTML = `
          <span>${result.currentPage} dari ${result.pageCount} (${result.totalItems} barang)</span>
        `;
      }

      const PaginateButton = document.getElementById("paginate_button_restock");
      if (result.backPage) {
        PaginateButton.innerHTML += `
          <button class="back" onclick="RestockTrashList({url: '${result.backPage}'})">
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
              <button class="number" onclick="RestockTrashList({url: '${siteURL}/goods/goods_list?page=${i}'})">
                ${i}
              </button>
            `;
        }

        for (i = result.currentPage; i <= result.pageCount; i++) {
          if (result.currentPage != i) {
            PaginateButton.innerHTML += `
              <button class="number" onclick="RestockTrashList({url: '${siteURL}/goods/goods_list?page=${i}'})">
                ${i}
              </button>
            `;
          }
        }
      }

      if (result.nextPage) {
        PaginateButton.innerHTML += `
          <button class="back" onclick="RestockTrashList({url: '${result.nextPage}'})">
            Next
          </button>
        `;
      }
    } else {
      tabelTrashRestock.innerHTML = `
      <tr>
        <td colspan="6" >
          <div class="table_loading">
            <img src="${baseURL}/assets/icons/not-line-black-1.svg" alt="not-line">
          </div>
        </td>
      </tr>
      `;
    }
  }, result);
}

loadData({
  text: `/trash`,
  fnc: `GoodsTrashList({url: '${baseURL}/goods/trash'})`,
});

async function GoodsTrashList({ url }) {
  tabelTrashGoods.innerHTML = tableLoading({
    col: 6,
    element: ["paginate_button_goods", "paginate_text_goods"],
  });

  const result = await get({ url: url });
  tabelTrashGoods.innerHTML = "";

  setTimeout((async) => {
    if (result && result.goods.length > 0) {
      var noList = (result.currentPage - 1) * result.perPage + 1;
      result.goods.map((list) => {
        tabelTrashGoods.innerHTML += TabelTrashGoods({
          no: noList,
          value: list,
        });
        noList++;
      });

      const PaginateText = document.getElementById("paginate_text_goods");
      if (result.currentPage && result.pageCount && result.totalItems) {
        PaginateText.innerHTML = `
          <span>${result.currentPage} dari ${result.pageCount} (${result.totalItems} barang)</span>
        `;
      }

      const PaginateButton = document.getElementById("paginate_button_goods");
      if (result.backPage) {
        PaginateButton.innerHTML += `
          <button class="back" onclick="GoodsTrashList({url: '${result.backPage}'})">
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
              <button class="number" onclick="GoodsTrashList({url: '${siteURL}/goods/goods_list?page=${i}'})">
                ${i}
              </button>
            `;
        }

        for (i = result.currentPage; i <= result.pageCount; i++) {
          if (result.currentPage != i) {
            PaginateButton.innerHTML += `
              <button class="number" onclick="GoodsTrashList({url: '${siteURL}/goods/goods_list?page=${i}'})">
                ${i}
              </button>
            `;
          }
        }
      }

      if (result.nextPage) {
        PaginateButton.innerHTML += `
          <button class="back" onclick="GoodsTrashList({url: '${result.nextPage}'})">
            Next
          </button>
        `;
      }
    } else {
      tabelTrashGoods.innerHTML = `
      <tr>
        <td colspan="6" >
          <div class="table_loading">
            <img src="${baseURL}/assets/icons/not-line-black-1.svg" alt="not-line">
          </div>
        </td>
      </tr>
      `;
    }
  }, result);
}

loadData({
  text: `/dashboard`,
  fnc: `ChartHistory()`,
});

async function ChartHistory() {
  const url = `${siteURL}/goods_history`;
  const result = await get({
    url: url,
  });

  setTimeout(() => {
    const data1 = result.goodsHistory;
    const data2 = result.goodsRestock;

    if (role == "admin") {
      new Chart(document.getElementById("goods_in"), {
        type: "line",
        data: {
          labels: data1.map((row) => row.key),
          datasets: [
            {
              label: "Total barang masuk (per 7 hari)",
              data: data1.map((row) => row.qty),
              borderColor: "#599afe",
            },
          ],
          options: {
            responsive: true,
            maintainAspectRatio: false,
          },
        },
      });

      new Chart(document.getElementById("goods_out"), {
        type: "line",
        data: {
          labels: data2.map((row) => row.key),
          datasets: [
            {
              label: "Total barang keluar (per 7 hari)",
              data: data2.map((row) => row.qty),
              borderColor: "#df5338",
            },
          ],
          options: {
            responsive: true,
            maintainAspectRatio: false,
          },
        },
      });
    }

    GoodsInOut();
  }, result);
}

async function GoodsInOut() {
  const getDate = document.getElementById("input-date").value;
  const url = `${siteURL}/goods_in_out`;

  const data = {
    date: getDate,
  };

  const result = await post({ url: url, data: data });

  setTimeout(() => {
    if (Array.isArray(window.myChart)) {
      window.myChart.forEach((chart) => chart.destroy());
    }

    const createBarChart = (canvasId, chartData, label, backgroundColor) => {
      var MyChart = new Chart(document.getElementById(canvasId), {
        type: "bar",
        data: {
          labels: chartData.map((row) =>
            row.name.length > 15 ? row.name.substring(0, 15) + "..." : row.name
          ),
          datasets: [
            {
              label: label,
              data: chartData.map((row) => row.qty),
              backgroundColor: backgroundColor,
            },
          ],
        },
        options: {
          indexAxis: "y",
          responsive: true,
          maintainAspectRatio: false,
        },
      });

      return MyChart;
    };

    const chart1 = createBarChart(
      "goods_in_list",
      result.goodsIn,
      "Barang masuk",
      "#599afe"
    );
    const chart2 = createBarChart(
      "goods_out_list",
      result.goodsOut,
      "Barang keluar",
      "#df5338"
    );

    window.myChart = [chart1, chart2];
  }, result);
}
