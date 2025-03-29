<script setup lang="ts">
import type { MenuCategory } from "./types/MenuItem";
import CardItemList from "./components/CardItemList.vue";

const menu: MenuCategory[] = [
  {
    category: "Nigiri",
    items: [
      {
        name: "Z łososiem",
        price: 22,
        image: "/images/menu/1.webp",
        description:
          "Delikatny plaster świeżego łososia na poduszce z ryżu, idealnie komponujący się z wasabi i sosem sojowym.",
        count: "2szt.",
      },
      {
        name: "Z tuńczykiem",
        price: 24,
        image: "/images/menu/2.webp",
        description:
          "Soczysty kawałek tuńczyka o intensywnym smaku, podany na perfekcyjnie uformowanym ryżu.",
        count: "2szt.",
      },
      {
        name: "Z węgorzem",
        price: 24,
        image: "/images/menu/3.webp",
        description:
          "Aromatyczny i lekko słodkawy grillowany węgorz z japońskim sosem unagi, który nadaje wyjątkowej głębi smaku.",
        count: "2szt.",
      },
      {
        name: "Z wędzonym łososiem",
        price: 23,
        image: "/images/menu/4.webp",
        description:
          "Klasyczna kombinacja delikatnie wędzonego łososia i lekko zakwaszonego ryżu, która rozpływa się w ustach.  ",
        count: "2szt.",
      },
      {
        name: "Z krewetką",
        price: 22,
        image: "/images/menu/5.webp",
        description:
          "Soczysta, lekko słodkawa krewetka ułożona na miękkim ryżu, tworząc harmonijną i subtelną kompozycję.",
        count: "2szt.",
      },
    ],
  },

  {
    category: "Gunkan",
    items: [
      {
        name: "Z masago",
        price: 24,
        image: "/images/menu/6.webp",
        description:
          " Delikatne ryżowe łódeczki wypełnione świeżymi jajkami ryb masago, które dodają wyjątkowego smaku i chrupkości.",
        count: "2szt.",
      },
      {
        name: "Z hiyashi",
        price: 22,
        image: "/images/menu/7.webp",
        description:
          "Chłodny, orzeźwiający gunkan z surowymi warzywami i dressingiem, idealny na letnie dni, oferujący lekkość i świeżość w każdym kęsie.",
        count: "2szt.",
      },
    ],
  },
  {
    category: "Maki Roll",
    items: [
      {
        name: "Z ogórkiem",
        price: 15,
        image: "/images/menu/8.webp",
        description:
          "Lekka i orzeźwiająca rolka z chrupiącym ogórkiem, która doskonale łączy się z ryżem i nori.",
        count: "6szt.",
      },
      {
        name: "Z awokado",
        price: 17,
        image: "/images/menu/9.webp",
        description:
          "Kremowe, dojrzałe awokado w połączeniu z ryżem i nori, tworzy delikatną, pełną smaku rolkę.",
        count: "6szt.",
      },
      {
        name: "Z surimi",
        price: 16,
        image: "/images/menu/10.webp",
        description:
          "Rolka z surimi, imitacją krewetek, która oferuje subtelną morską nutę w połączeniu z ryżem i warzywami.",
        count: "6szt.",
      },
      {
        name: "Z krewetką",
        price: 24,
        image: "/images/menu/11.webp",
        description:
          "Rolka z soczystą krewetką, która nadaje daniu lekkości i świeżości.",
        count: "6szt.",
      },
      {
        name: "Z krewetką w tempurze",
        price: 26,
        image: "/images/menu/12.webp",
        description:
          "Chrupiąca krewetka w cieście tempura, która dodaje rolce wyjątkowej tekstury i smaku.",
        count: "6szt.",
      },
      {
        name: "Z łososiem",
        price: 24,
        image: "/images/menu/13.webp",
        description:
          "Świeży łosoś w połączeniu z ryżem i nori, tworzy harmonijną i pełną smaku rolkę.",
        count: "6szt.",
      },
      {
        name: "Z wędzonym łososiem",
        price: 25,
        image: "/images/menu/14.webp",
        description:
          "Wędzony łosoś, którego głęboki smak doskonale łączy się z ryżem, tworząc intensywną rolkę.",
        count: "6szt.",
      },
      {
        name: "Z tuńczykiem",
        price: 25,
        image: "/images/menu/15.webp",
        description:
          "Soczysty kawałek tuńczyka, który łączy się z ryżem, tworząc rolkę o wyrazistym smaku.",
        count: "6szt.",
      },
      {
        name: "Z węgorzem",
        price: 25,
        image: "/images/menu/16.webp",
        description:
          "Grillowany węgorz, który nadaje rolce delikatnie słodkawy smak, idealnie łącząc się z ryżem i sosem unagi.",
        count: "6szt.",
      },
    ],
  },
  {
    category: "Kalifornia Roll",
    items: [
      {
        name: "Z łososiem",
        price: 37,
        image: "/images/menu/17.webp",
        description:
          "Pyszna rolka z kawałkami świeżego łososia, awokado i ogórkiem, otoczona ziarnami sezamu, tworząc harmonijną kompozycję smakową.",
        count: "(masago,awokado,ogórek), 8szt.",
      },
      {
        name: "Z wędzonym łososiem",
        price: 38,
        image: "/images/menu/18.webp",
        description:
          "Połączenie wędzonego łososia, awokado i ogórka w delikatnym ryżowym zawiniątku, które oferuje intensywny, dymny smak.",
        count: "(sezam,awokado,ogórek), 8szt.",
      },
      {
        name: "Z lekko solonym łososiem",
        price: 38,
        image: "/images/menu/19.webp",
        description:
          "Wyjątkowa rolka z solonym łososiem, awokado i ogórkiem, otoczona sezamem, oferująca subtelną, słonawą nutę smaku.",
        count: "(sezam,awokado,ogórek), 8szt.",
      },
      {
        name: "Klasyczna",
        price: 36,
        image: "/images/menu/20.webp",
        description:
          "Klasyczna wersja rolla z kawałkami surimi, awokado, ogórkiem, otoczona ziarnami sezamu, idealna dla fanów tradycyjnych smaków.",
        count: "(surimi,masago,ogórek,awokado,majonez), 8szt.",
      },
    ],
  },
  {
    category: "Smok",
    items: [
      {
        name: "Czerwony",
        price: 48,
        image: "/images/menu/21.webp",
        description:
          "Rolka z pikantnym tuńczykiem, awokado i świeżym ogórkiem, otoczona w czerwoną glazurę z sosem chili, dodającą ostrości i wyrazistości. ",
        count: "(tuńczyk,węgorz,masago,ogórek,tamago), 8szt.",
      },
      {
        name: "Pomarańczowy",
        price: 46,
        image: "/images/menu/22.webp",
        description:
          "Połączenie delikatnego łososia, kremowego awokado i świeżego ogórka, otoczonego w pomarańczowej glazurze, która nadaje soczystości i owocowego posmaku.  ",
        count: "(losoś węgorz,masago,ogórek,tamago), 8szt.",
      },
      {
        name: "Złoty",
        price: 48,
        image: "/images/menu/23.webp",
        description:
          "Elegancka rolka z wędzonym łososiem, awokado i sezamem, otoczona złotą glazurą, która podkreśla jej wykwintny smak i aromat. ",
        count: "(węgorz,masago,ogórek,tamago), 8szt.",
      },
      {
        name: "Zielony",
        price: 45,
        image: "/images/menu/24.webp",
        description:
          "Świeża rolka z awokado, ogórkiem i tuńczykiem, obleczona w zieloną glazurę, która nadaje jej orzeźwiający smak i lekkość.  ",
        count: "(awokado,węgorz,masago,ogórek,tamago), 8szt.",
      },
      {
        name: "Tygrysowy",
        price: 47,
        image: "/images/menu/25.webp",
        description:
          "Rolka z pikantnym krewetką, awokado i ogórkiem, otoczona w aromatycznej glazurze, wzbogacona o chrupiące dodatki, tworząca mocny, wyrazisty smak.",
        count: "(krewetka Ebi,węgorz,masago,ogórek,tamago), 8szt.",
      },
    ],
  },

  {
    category: "Futomaki",
    items: [
      {
        name: "Z wędzonym kurczakiem ",
        price: 35,
        image: "/images/menu/empty.svg",
        // description: "",
        count:
          "(szczypior,pomidor,ogórek,sałata lodowa,sos sriracza mayo), 8szt.",
      },
      {
        name: "Z łososiem i serem cheddar ",
        price: 38,
        image: "/images/menu/empty.svg",
        // description: "",
        count:
          "(serek,krewetka gotowana,mix z surimi,sałata lodowa,cheddar,losoś), 8szt.",
      },
    ],
  },

  {
    category: "Krancz",
    items: [
      {
        name: "Z krewetką w tempurze",
        price: 36,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(masago,chrupki,ogórek,majonez), 8szt.",
      },
      {
        name: "Z surimi ",
        price: 33,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(masgo,chrupki,ogórek,shitake,majonez), 8szt.",
      },
    ],
  },

  {
    category: "Filadelfia",
    items: [
      {
        name: "Z łososiem ",
        price: 37,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(serek,awokado), 8szt.",
      },
      {
        name: "Z wędzonym lososiem ",
        price: 39,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(serek,ogórek), 8szt.",
      },
      {
        name: "Unagi",
        price: 44,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(sezam,serek,masago,węgorz,ogórek,awokado), 8szt.",
      },
      {
        name: "Z tuńczykiem ",
        price: 44,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(serek,awokado), 8szt.",
      },
      {
        name: "Ebi",
        price: 44,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(serek,losos,awokado), 8szt.",
      },
      {
        name: "Cheddar",
        price: 38,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(serek,losoś lekko słony), 8szt.",
      },
      {
        name: "Z krewetką w tempurze ",
        price: 43,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(serek,ogórek,losoś), 8szt.",
      },
    ],
  },

  {
    category: "Smażony Roll",
    items: [
      {
        name: "Tempura Smok",
        price: 40,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(węgorz,tamago,awokado,serek), 8szt.",
      },
      {
        name: "Z łososiem i krewetką ",
        price: 37,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(masago,awokado,ogórek,losoś,krewetka gotowana,serek), 8szt.",
      },
    ],
  },

  {
    category: "Pieczony Roll",
    items: [
      {
        name: "Z krewetką",
        price: 40,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(w środku:ogórek surimi. Z góry mieszanka z krewetką), 8szt.",
      },
      {
        name: "Z łososiem",
        price: 41,
        image: "/images/menu/empty.svg",
        // description: "",
        count:
          "(w środku:awokado, mix z surimi. Z góry mieszanka z losośa), 8szt.",
      },
      {
        name: "Z węgorzem",
        price: 43,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(w środku serek. Zgóry mieszanka węgorza), 8szt.",
      },
    ],
  },

  {
    category: "Salatka",
    items: [
      {
        name: "Wakame goma z sosem sezamowym",
        price: 15,
        image: "/images/menu/empty.svg",
        // description: "",
        // count: ", 8szt."
      },
    ],
  },

  {
    category: "Przekąski",
    items: [
      {
        name: "Krewetki w tempurze z sosem",
        price: 42,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "6szt.",
      },
    ],
  },

  {
    category: "Zupy",
    items: [
      {
        name: "Miso Klasyczna",
        price: 20,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(tofu,shitake,wakame,sezam,szczypior), 8szt.",
      },
      {
        name: "Miso z łososiem",
        price: 25,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(tofu,shitake,wakame,sezam,szczypior), 8szt.",
      },
    ],
  },

  {
    category: "Smażony Ryż „Tiachan“",
    items: [
      {
        name: "Z jajkiem",
        price: 25,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(ryż,jajo,szczypior,sezam), 8szt.",
      },
      {
        name: "Z kurczakiem",
        price: 30,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(ryż,jajo,szczypior,sezam), 8szt.",
      },
      {
        name: "Z krewetką ",
        price: 32,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(ryż,jajo,szczypior,sezam), 8szt.",
      },
    ],
  },

  {
    category: "Zestawy",
    items: [
      {
        name: "Mega Smok",
        price: 260,
        image: "/images/menu/empty.svg",
        count:
          "(Czerwony smok, Pomarańczowy smok, Złoty smok, Zielony smok,Tygrysowy smok, Tempura smok)",
      },
      {
        name: "Mini Smok",
        price: 125,
        image: "/images/menu/empty.svg",
        count: "(Pomarańczowy smok,Złoty smok,Zielony smok)",
      },
      {
        name: "Fila Set",
        price: 150,
        image: "/images/menu/empty.svg",
        count:
          "(Fila losoś, Fila tunczyk, Fila Unagi, Fila z wędzonym lososiem)",
      },
      {
        name: "Beer Set",
        price: 145,
        image: "/images/menu/empty.svg",
        count:
          "(Futomaki z wędzonym kurczakiem, Kalifornia z wędzonym lososiem, kalifornia z lrkko słonym lososiem, Krewetki w tempurze)",
      },
      {
        name: "Maki Set",
        price: 109,
        image: "/images/menu/empty.svg",
        count:
          "(Maki z: lososiem, węgorzem,krewetką,wędzonym lososiem,ogórkiem, awokado)",
      },
      {
        name: "Set z łososiem",
        price: 150,
        image: "/images/menu/empty.svg",
        count:
          "(Fila losoś,Fila z krewetką w tempurze,Kalifornia z lososiem, Maki zlososiem, Nigiri z lososiem)",
      },
    ],
  },
  {
    category: "Dodatki",
    items: [
      {
        name: "Sos sezamowy",
        price: 5,
        // image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        name: "Sos teriyaki ",
        price: 5,
        // image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        name: "Sos sriracza mayo",
        price: 5,
        // image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        name: "Sos sriracza",
        price: 5,
        // image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        name: "Imbir marynowany ",
        price: 5,
        // image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        name: "Sos sojowy",
        price: 5,
        // image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        name: "Wasabi",
        price: 5,
        // image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
    ],
  },
];

const scrollTo = (category: string) => {
  const element = document.getElementById(category);
  if (element) {
    const offset = 28;
    const elementPosition =
      element.getBoundingClientRect().top + window.scrollY;
    window.scrollTo({ top: elementPosition - offset, behavior: "smooth" });
  }
};
</script>

<template>
  <header class="header">
    <div class="container">
      <img src="./assets/header.webp" alt="header" />
      <img src="./assets/logo.webp" class="logo" alt="header" />
    </div>
  </header>
  <main class="main">
    <div class="container">
      <div class="main-place">
        <div class="main-place-row">
          <h1 class="main-place-title">Sushi Smok</h1>
          <a href="tel:+48880503760" class="main-place-phone">
            +48 880 503 760</a
          >
        </div>
        <a
          class="main-place-address"
          href="https://maps.app.goo.gl/QGLZegSUG5hXpC527"
          rel="nofollow"
          target="_blank"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 256 256"
            width="16"
            height="16"
            fill="currentColor"
          >
            <g>
              <path
                d="M128,64a40,40,0,1,0,40,40A40,40,0,0,0,128,64Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,128Zm0-112a88.1,88.1,0,0,0-88,88c0,31.4,14.51,64.68,42,96.25a254.19,254.19,0,0,0,41.45,38.3,8,8,0,0,0,9.18,0A254.19,254.19,0,0,0,174,200.25c27.45-31.57,42-64.85,42-96.25A88.1,88.1,0,0,0,128,16Zm0,206c-16.53-13-72-60.75-72-118a72,72,0,0,1,144,0C200,161.23,144.53,209,128,222Z"
              ></path>
            </g>
          </svg>
          <span>Pomarańczowa 7, 70-781 Szczecin, Polska</span>
        </a>
        <a
          class="main-place-social"
          href="https://www.instagram.com/sushismok_s/"
          rel="nofollow"
          target="_blank"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"
            />
          </svg>

          @sushismok_s
        </a>
      </div>
      <div class="cards">
        <ul class="menu">
          <li v-for="(items, index) in menu" :key="index">
            <a href="#" @click.prevent="scrollTo(items.category)">
              {{ items.category }}
            </a>
          </li>
        </ul>
        <div
          class="cards-item"
          v-for="(items, index) in menu"
          :key="items.category"
          :id="items.category"
        >
          <h4 class="cards-item-title">
            {{ items.category }}
          </h4>

          <CardItemList :items="menu[index].items" />
        </div>
      </div>
    </div>
  </main>
  <footer class="footer">&#169; sushismok.ct.ws</footer>
</template>

<style scoped lang="scss">
.header {
  max-width: 560px;
  margin: 0 auto;
  position: relative;

  img {
    height: 172px;
    object-fit: cover;
    width: 100%;
    object-position: 50% 98%;

    &.logo {
      height: 82px;
      width: 82px;
      border-radius: 50%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translateX(-50%) translateY(-50%);
    }
  }
}

.main {
  max-width: 560px;
  margin: 0 auto;
  background: #181818;
  border-radius: 24px 24px 0 0;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  margin-top: -32px;
  padding-bottom: 24px;
  padding-top: 24px;
  position: relative;
  max-width: 560px;
  padding-left: 16px;
  padding-right: 16px;
  min-height: 100vh;

  &-place {
    display: flex;
    flex-direction: column;
    gap: 8px;
    color: #fff;
    margin-bottom: 24px;

    &-title {
      font-size: 24px;
      font-weight: bold;
    }

    &-phone {
      color: #d1be8f;
      font-size: 21px;
      font-weight: bold;
      text-decoration: none;
    }

    &-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    &-address,
    &-social {
      display: flex;
      align-items: center;
      gap: 4px;
      color: #676767;
      text-decoration: none;
      transition: 0.3s;

      &:hover {
        color: #fff;
      }
    }
  }
}

.cards {
  display: flex;
  flex-direction: column;
  row-gap: 12px;

  &-item {
    background: #252525;
    border-radius: 24px;
    padding: 12px;

    &-title {
      color: #d1be8f;
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 8px;
    }
  }
}

.menu {
  position: sticky;
  top: 0;
  display: flex;
  align-items: center;
  gap: 6px;
  width: 100%;
  overflow-x: auto;
  background: #181818;
  padding: 4px 0;

  li {
    a {
      display: block;
      color: #ccc;
      border: 1px solid #ccc;
      padding: 4px 8px;
      text-decoration: none;
      border-radius: 100px;
      transition: 0.3s;
      text-wrap: nowrap;

      &:hover {
        background: #ccc;
        color: #181818;
      }
    }
  }
}

.footer {
  text-align: center;
  color: #676767;
  max-width: 560px;
  margin: 0 auto;
  position: relative;
  background: #181818;
  padding-bottom: 24px;
}
</style>
