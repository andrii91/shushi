import type { MenuCategory } from "../types/MenuItem";

export const menu: MenuCategory[] = [
  {
    category: "Nigiri",
    items: [
      {
        id: 0,
        name: "Z łososiem",
        price: 22,
        image: "/images/menu/1.webp",
        description:
          "Delikatny plaster świeżego łososia na poduszce z ryżu, idealnie komponujący się z wasabi i sosem sojowym.",
        count: "2szt.",
      },
      {
        id: 1,
        name: "Z tuńczykiem",
        price: 24,
        image: "/images/menu/2.webp",
        description:
          "Soczysty kawałek tuńczyka o intensywnym smaku, podany na perfekcyjnie uformowanym ryżu.",
        count: "2szt.",
      },
      {
        id: 2,
        name: "Z węgorzem",
        price: 24,
        image: "/images/menu/3.webp",
        description:
          "Aromatyczny i lekko słodkawy grillowany węgorz z japońskim sosem unagi, który nadaje wyjątkowej głębi smaku.",
        count: "2szt.",
      },
      {
        id: 3,
        name: "Z wędzonym łososiem",
        price: 23,
        image: "/images/menu/4.webp",
        description:
          "Klasyczna kombinacja delikatnie wędzonego łososia i lekko zakwaszonego ryżu, która rozpływa się w ustach.  ",
        count: "2szt.",
      },
      {
        id: 4,
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
        id: 5,
        name: "Z masago",
        price: 24,
        image: "/images/menu/6.webp",
        description:
          " Delikatne ryżowe łódeczki wypełnione świeżymi jajkami ryb masago,  które dodają wyjątkowego smaku i chrupkości.",
        count: "2szt.",
      },
      {
        id: 6,
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
        id: 7,
        name: "Z ogórkiem",
        price: 15,
        image: "/images/menu/8.webp",
        description:
          "Lekka i orzeźwiająca rolka z chrupiącym ogórkiem, która doskonale łączy się z ryżem i nori.",
        count: "6szt.",
      },
      {
        id: 8,
        name: "Z awokado",
        price: 17,
        image: "/images/menu/9.webp",
        description:
          "Kremowe, dojrzałe awokado w połączeniu z ryżem i nori, tworzy delikatną, pełną smaku rolkę.",
        count: "6szt.",
      },
      {
        id: 9,
        name: "Z surimi",
        price: 16,
        image: "/images/menu/10.webp",
        description:
          "Rolka z surimi,  imitacją krewetek, która oferuje subtelną morską nutę w połączeniu z ryżem i warzywami.",
        count: "6szt.",
      },
      {
        id: 10,
        name: "Z krewetką",
        price: 24,
        image: "/images/menu/11.webp",
        description:
          "Rolka z soczystą krewetką,  która nadaje daniu lekkości i świeżości.",
        count: "6szt.",
      },
      {
        id: 11,
        name: "Z krewetką w tempurze",
        price: 26,
        image: "/images/menu/12.webp",
        description:
          "Chrupiąca krewetka w cieście tempura, która dodaje rolce wyjątkowej tekstury i smaku.",
        count: "6szt.",
      },
      {
        id: 12,
        name: "Z łososiem",
        price: 24,
        image: "/images/menu/13.webp",
        description:
          "Świeży łosoś w połączeniu z ryżem i nori, tworzy harmonijną i pełną smaku rolkę.",
        count: "6szt.",
      },
      {
        id: 13,
        name: "Z wędzonym łososiem",
        price: 25,
        image: "/images/menu/14.webp",
        description:
          "Wędzony łosoś, którego głęboki smak doskonale łączy się z ryżem, tworząc intensywną rolkę.",
        count: "6szt.",
      },
      {
        id: 14,
        name: "Z tuńczykiem",
        price: 25,
        image: "/images/menu/15.webp",
        description:
          "Soczysty kawałek tuńczyka, który łączy się z ryżem, tworząc rolkę o wyrazistym smaku.",
        count: "6szt.",
      },
      {
        id: 15,
        name: "Z węgorzem",
        price: 25,
        image: "/images/menu/16.webp",
        description:
          "Grillowany węgorz,  który nadaje rolce delikatnie słodkawy smak, idealnie łącząc się z ryżem i sosem unagi.",
        count: "6szt.",
      },
    ],
  },
  {
    category: "Kalifornia Roll",
    items: [
      {
        id: 16,
        name: "Z łososiem",
        price: 37,
        image: "/images/menu/17.webp",
        description:
          "Pyszna rolka z kawałkami świeżego łososia, awokado i ogórkiem, otoczona ziarnami sezamu, tworząc harmonijną kompozycję smakową.",
        count: "(masago, awokado, ogórek), 8szt.",
      },
      {
        id: 17,
        name: "Z wędzonym łososiem",
        price: 38,
        image: "/images/menu/18.webp",
        description:
          "Połączenie wędzonego łososia, awokado i ogórka w delikatnym ryżowym zawiniątku, które oferuje intensywny, dymny smak.",
        count: "(sezam, awokado, ogórek), 8szt.",
      },
      {
        id: 18,
        name: "Z lekko solonym łososiem",
        price: 38,
        image: "/images/menu/19.webp",
        description:
          "Wyjątkowa rolka z solonym łososiem, awokado i ogórkiem, otoczona sezamem, oferująca subtelną, słonawą nutę smaku.",
        count: "(sezam, awokado, ogórek), 8szt.",
      },
      {
        id: 19,
        name: "Klasyczna",
        price: 36,
        image: "/images/menu/20.webp",
        description:
          "Klasyczna wersja rolla z kawałkami surimi,  awokado,  ogórkiem, otoczona ziarnami sezamu, idealna dla fanów tradycyjnych smaków.",
        count: "(surimi, masago, ogórek, awokado, majonez), 8szt.",
      },
    ],
  },
  {
    category: "Smok",
    items: [
      {
        id: 20,
        name: "Czerwony",
        price: 48,
        image: "/images/menu/21.webp",
        description:
          "Rolka z pikantnym tuńczykiem, awokado i świeżym ogórkiem, otoczona w czerwoną glazurę z sosem chili, dodającą ostrości i wyrazistości. ",
        count: "(tuńczyk, węgorz, masago, ogórek, tamago), 8szt.",
      },
      {
        id: 21,
        name: "Pomarańczowy",
        price: 46,
        image: "/images/menu/22.webp",
        description:
          "Połączenie delikatnego łososia, kremowego awokado i świeżego ogórka, otoczonego w pomarańczowej glazurze, która nadaje soczystości i owocowego posmaku.  ",
        count: "(losoś węgorz, masago, ogórek, tamago), 8szt.",
      },
      {
        id: 22,
        name: "Złoty",
        price: 48,
        image: "/images/menu/23.webp",
        description:
          "Elegancka rolka z wędzonym łososiem, awokado i sezamem, otoczona złotą glazurą, która podkreśla jej wykwintny smak i aromat. ",
        count: "(węgorz, masago, ogórek, tamago), 8szt.",
      },
      {
        id: 23,
        name: "Zielony",
        price: 45,
        image: "/images/menu/24.webp",
        description:
          "Świeża rolka z awokado,  ogórkiem i tuńczykiem, obleczona w zieloną glazurę, która nadaje jej orzeźwiający smak i lekkość.  ",
        count: "(awokado, węgorz, masago, ogórek, tamago), 8szt.",
      },
      {
        id: 24,
        name: "Tygrysowy",
        price: 47,
        image: "/images/menu/25.webp",
        description:
          "Rolka z pikantnym krewetką,  awokado i ogórkiem, otoczona w aromatycznej glazurze, wzbogacona o chrupiące dodatki, tworząca mocny, wyrazisty smak.",
        count: "(krewetka Ebi,węgorz, masago, ogórek, tamago), 8szt.",
      },
    ],
  },

  {
    category: "Futomaki",
    items: [
      {
        id: 25,
        name: "Z wędzonym kurczakiem ",
        price: 35,
        image: "/images/menu/empty.svg",
        // description: "",
        count:
          "(szczypior, pomidor, ogórek, sałata lodowa, sos sriracza mayo), 8szt.",
      },
      {
        id: 26,
        name: "Z łososiem i serem cheddar ",
        price: 38,
        image: "/images/menu/empty.svg",
        // description: "",
        count:
          "(serek, krewetka gotowana,mix z surimi, sałata lodowa, cheddar, losoś), 8szt.",
      },
    ],
  },

  {
    category: "Krancz",
    items: [
      {
        id: 27,
        name: "Z krewetką w tempurze",
        price: 36,
        image: "/images/menu/28.webp",
        description: "Krancz z krewetką w tempurze to chrupiąca rolka sushi z masago, chrupkami, ogórkiem i majonezem, łącząca delikatność krewetki z wyrazistym smakiem dodatków.",
        count: "(masago, chrupki, ogórek, majonez), 8szt.",
      },
      {
        id: 28,
        name: "Z surimi ",
        price: 33,
        image: "/images/menu/29.webp",
        description: "Krancz Z surimi to wyjątkowe połączenie masago, chrupiących dodatków, ogórka, grzybów shiitake i delikatnego majonezu, tworzące harmonijną kompozycję smaków i tekstur.",
        count: "(masgo, chrupki, ogórek, shitake, majonez), 8szt.",
      },
    ],
  },

  {
    category: "Filadelfia",
    items: [
      {
        id: 29,
        name: "Z łososiem ",
        price: 37,
        image: "/images/menu/30.webp",
        description: "Filadelfia z łososiem to klasyczna rolka sushi, w której delikatny serek śmietankowy łączy się z kremowym awokado i soczystym, świeżym łososiem. To połączenie tworzy aksamitny i harmonijny smak, idealny dla miłośników łagodnych, ale wyrafinowanych kompozycji.",
        count: "(serek, awokado), 8szt.",
      },
      {
        id: 30,
        name: "Z wędzonym lososiem ",
        price: 39,
        image: "/images/menu/31.webp",
        description: "Filadelfia z wędzonym łososiem to klasyczna rolka sushi składająca się z kremowego serka, świeżego ogórka i delikatnego wędzonego łososia. Zawinięta w idealnie ugotowany ryż i nori, oferuje harmonijną kombinację smaków i kremowej konsystencji.",
        count: "(serek, ogórek), 8szt.",
      },
      {
        id: 31,
        name: "Unagi",
        price: 44,
        image: "/images/menu/32.webp",
        description: "Filadelfia Unagi to pyszna rolka sushi, łącząca kremowy serek i chrupiący sezam z intensywnym smakiem węgorza (unagi). Dodatek masago nadaje delikatnej tekstury, a świeży ogórek i awokado zapewniają idealną równowagę smaków.",
        count: "(sezam, serek, masago, węgorz, ogórek, awokado), 8szt.",
      },
      {
        id: 32,
        name: "Z tuńczykiem ",
        price: 44,
        image: "/images/menu/33.webp",
        description: "Filadelfia z tuńczykiem to pyszna rolka sushi z kremowym serkiem, delikatnym tuńczykiem i aksamitnym awokado, owinięta w nori i ryż. Idealne połączenie smaków dla miłośników sushi!",
        count: "(serek, awokado), 8szt.",
      },
      {
        id: 33,
        name: "Ebi",
        price: 44,
        image: "/images/menu/34.webp",
        description: "Filadelfia Ebi to klasyczna rolka sushi, składająca się z kremowego serka, świeżego łososia i aksamitnego awokado. Delikatne połączenie smaków sprawia, że jest to jedna z najpopularniejszych pozycji w menu sushi.",
        count: "(serek, losos, awokado), 8szt.",
      },
      {
        id: 34,
        name: "Cheddar",
        price: 38,
        image: "/images/menu/35.webp",
        description: "Filadelfia Cheddar to kremowy serek o intensywnym smaku cheddara i delikatnie słonym aromacie łososia. Idealny do kanapek, przekąsek i sosów, łączy wyrazisty serowy charakter z nutą rybnej delikatności.",
        count: "(serek, losoś lekko słony), 8szt.",
      },
      {
        id: 35,
        name: "Z krewetką w tempurze ",
        price: 43,
        image: "/images/menu/36.webp",
        description: "Filadelfia z krewetką w tempurze to pyszna rolka sushi z kremowym serkiem, świeżym ogórkiem i łososiem, wzbogacona chrupiącą krewetką w tempurze. Delikatna, a zarazem pełna smaku!",
        count: "(serek, ogórek, losoś), 8szt.",
      },
    ],
  },

  {
    category: "Smażony Roll",
    items: [
      {
        id: 36,
        name: "Tempura Smok",
        price: 40,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(węgorz, tamago, awokado, serek), 8szt.",
      },
      {
        id: 37,
        name: "Z łososiem i krewetką ",
        price: 37,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(masago, awokado, ogórek, losoś, krewetka gotowana,serek), 8szt.",
      },
    ],
  },

  {
    category: "Pieczony Roll",
    items: [
      {
        id: 38,
        name: "Z krewetką",
        price: 40,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(w środku: ogórek surimi. Z góry mieszanka z krewetką), 8szt.",
      },
      {
        id: 39,
        name: "Z łososiem",
        price: 41,
        image: "/images/menu/empty.svg",
        // description: "",
        count:
          "(w środku: awokado,  mix z surimi. Z góry mieszanka z losośa), 8szt.",
      },
      {
        id: 40,
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
        id: 41,
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
        id: 42,
        name: "Krewetki w tempurze z sosem",
        price: 42,
        image: "/images/menu/43.webp",
        description: "Chrupiące krewetki w lekkiej tempurze, podawane z aromatycznym sosem, to idealna przekąska dla miłośników wyrafinowanego smaku i delikatnej tekstury.",
        count: "6szt.",
      },
    ],
  },

  {
    category: "Zupy",
    items: [
      {
        id: 43,
        name: "Miso Klasyczna",
        price: 20,
        image: "/images/menu/empty.svg",
        description: "Miso Klasyczna to aromatyczna zupa na bazie miso z tofu, grzybami shiitake, wakame, sezamem i szczypiorem, oferująca głęboki, umami smak i idealne rozgrzanie w każdej chwili.",
        count: "(tofu, shitake,  wakame, sezam,  szczypior)",
      },
      {
        id: 44,
        name: "Miso z łososiem",
        price: 25,
        image: "/images/menu/45.webp",
        description: "Miso z łososiem to aromatyczna zupa na bazie pasty miso, wzbogacona tofu, grzybami shiitake, wodorostami wakame, sezamem i świeżym szczypiorem, tworząca pełnię smaku i ciepłego komfortu.",
        count: "(tofu, shitake,  wakame, sezam,  szczypior)",
      },
    ],
  },

  {
    category: "Smażony Ryż „Tiachan“",
    items: [
      {
        id: 45,
        name: "Z jajkiem",
        price: 25,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(ryż, jajo, szczypior, sezam), 8szt.",
      },
      {
        id: 46,
        name: "Z kurczakiem",
        price: 30,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(ryż, jajo, szczypior, sezam), 8szt.",
      },
      {
        id: 47,
        name: "Z krewetką ",
        price: 32,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "(ryż, jajo, szczypior, sezam), 8szt.",
      },
    ],
  },

  {
    category: "Zestawy",
    items: [
      {
        id: 48,
        name: "Mega Smok",
        price: 260,
        image: "/images/menu/empty.svg",
        count:
          "(Czerwony smok, Pomarańczowy smok,  Złoty smok,  Zielony smok, Tygrysowy smok, Tempura smok)",
      },
      {
        id: 49,
        name: "Mini Smok",
        price: 125,
        image: "/images/menu/empty.svg",
        count: "(Pomarańczowy smok, Złoty smok, Zielony smok)",
      },
      {
        id: 50,
        name: "Fila Set",
        price: 150,
        image: "/images/menu/empty.svg",
        count:
          "(Fila losoś,  Fila tunczyk, Fila Unagi, Fila z wędzonym lososiem)",
      },
      {
        id: 51,
        name: "Beer Set",
        price: 145,
        image: "/images/menu/empty.svg",
        count:
          "(Futomaki z wędzonym kurczakiem, Kalifornia z wędzonym lososiem,  kalifornia z lrkko słonym lososiem, Krewetki w tempurze)",
      },
      {
        id: 52,
        name: "Maki Set",
        price: 109,
        image: "/images/menu/empty.svg",
        count:
          "(Maki z: lososiem, węgorzem, krewetką, wędzonym lososiem, ogórkiem, awokado)",
      },
      {
        id: 53,
        name: "Set z łososiem",
        price: 150,
        image: "/images/menu/empty.svg",
        count:
          "(Fila losoś, Fila z krewetką w tempurze, Kalifornia z lososiem, Maki zlososiem, Nigiri z lososiem)",
      },
    ],
  },
  {
    category: "Dodatki",
    items: [
      {
        id: 54,
        name: "Sos sezamowy",
        price: 5,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        id: 55,
        name: "Sos teriyaki ",
        price: 5,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        id: 56,
        name: "Sos sriracza mayo",
        price: 5,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        id: 57,
        name: "Sos sriracza",
        price: 5,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        id: 58,
        name: "Imbir marynowany ",
        price: 5,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        id: 59,
        name: "Sos sojowy",
        price: 5,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
      {
        id: 60,
        name: "Wasabi",
        price: 5,
        image: "/images/menu/empty.svg",
        // description: "",
        count: "1szt.",
      },
    ],
  },
];