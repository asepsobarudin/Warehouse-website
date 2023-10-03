async function paginate(link, image) {
  try {
    const response = await fetch(link + "/product");

    if (!response.ok) {
      throw new Error("Error Network");
    }

    const data = await response.json();

    if (!data) {
      document.getElementById("product_container").innerHTML =
        "Data tidak ditemukan ";
    }

    if (data.code != 404) {
      document.getElementById("product_container").innerHTML = "";

      data.goods.map(async (list) => {
        const productCon = document.getElementById("product_container");
        productCon.innerHTML += `<div class="product_card">
        <img src="${image}/assets/images/image1.jpeg" alt="image">
        <div class="card_text">
          <a href="#">${list.name_goods}</a>
          <div>
            <span>${list.price}</span>
            <span>/${list.store_stok}</span>
          </div>
        </div>
        <button onclick="addCart('${list.kode_goods}')">
          <img src="${image}/assets/icons/add_cart.png" alt="add_cart">
        </button>
      </div>`;
      });

      const btnBack = document.getElementById("paginate_button");
      if (data.backPage && data.nextPage) {
        btnBack.innerHTML = `<button onclick="paginateButton('${data.backPage}')" class="back">Back</button>`;
        btnBack.innerHTML += `<button onclick="paginateButton('${data.nextPage}')" class="next">Next</button>`;
      } else if (data.backPage) {
        btnBack.innerHTML = `<button onclick="paginateButton('${data.backPage}')" class="back">Back</button>`;
      } else if (data.nextPage) {
        btnBack.innerHTML = `<button onclick="paginateButton('${data.nextPage}')" class="next">Next</button>`;
      }

      const textPaginate = document.getElementById("paginate_text");
      textPaginate.innerHTML = `
        <span>Page</span>
        <span>${data.currentPage}</span>
        <span>of</span>
        <span>${data.pageCount}</span>
        <span>(${data.totalItems} Barang)</span>
    `;
    }
  } catch (error) {
    console.log(error);
  }
}

function Search(link, image, keyword) {
  const dataToSend = {
    search: keyword,
  };
  fetch(link, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataToSend),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.goods.length != 0) {
        document.getElementById("product_container").innerHTML = "";

        data.goods.map(async (list) => {
          const productCon = document.getElementById("product_container");
          productCon.innerHTML += `<div class="product_card">
                  <img src="${image}/assets/images/image1.jpeg" alt="image">
                  <div class="card_text">
                    <a href="#">${list.name_goods}</a>
                    <div>
                      <span>${list.price}</span>
                      <span>/${list.store_stok}</span>
                    </div>
                  </div>
                  <button onclick="addCart('${list.kode_goods}')">
                    <img src="${image}/assets/icons/add_cart.png" alt="add_cart">
                  </button>
                </div>`;
        });

        const btnBack = document.getElementById("paginate_button");
        btnBack.innerHTML = "";
        if (data.backPage && data.nextPage) {
          btnBack.innerHTML = `<button onclick="paginateSearchBtn('${data.backPage}')" class="back">Back</button>`;
          btnBack.innerHTML += `<button onclick="paginateSearchBtn('${data.nextPage}')" class="next">Next</button>`;
        } else if (data.backPage) {
          btnBack.innerHTML = `<button onclick="paginateSearchBtn('${data.backPage}')" class="back">Back</button>`;
        } else if (data.nextPage) {
          btnBack.innerHTML = `<button onclick="paginateSearchBtn('${data.nextPage}')" class="next">Next</button>`;
        }

        const textPaginate = document.getElementById("paginate_text");
        textPaginate.innerHTML = "";
        textPaginate.innerHTML = `
              <span>Page</span>
              <span>${data.currentPage}</span>
              <span>of</span>
              <span>${data.pageCount}</span>
              <span>(${data.totalItems} Barang)</span>
              `;
      } else {
        document.getElementById("product_container").innerHTML = "Data tidak ditemukan";
        document.getElementById("paginate_button").innerHTML = "";
        document.getElementById("paginate_text").innerHTML = "";
      }
    })
    .catch((error) => {
      console.error(error);
    });
}
