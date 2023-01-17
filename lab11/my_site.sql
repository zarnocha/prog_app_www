-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 16, 2023 at 10:57 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `email`, `password`, `is_admin`) VALUES
(1, 'admin', '$2y$11$wVVfz1Eb8uVCiRyU5RxQNOE6euVbDEw.7YzY4VlXplUsS00W4Eqxu', 1),
(2, 'user', '$2y$11$C.8N/3F6LmETBSk3ns6Ms.nowlMq9UkOaQx9KRWqRb3HDFv9kWQay', 0),
(5, 'test', '$2y$11$JHE7OqyRDmmSsKYkuQvZLeQJuktyWkDyiSwNAGPZkN2WuZZE6K4Oq', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(11) NOT NULL,
  `master` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `master`, `name`) VALUES
(1, 0, 'Odzież'),
(2, 0, 'Obuwie'),
(3, 0, 'Akcesoria'),
(4, 0, 'Piłki'),
(5, 0, 'Dla kibica'),
(6, 1, 'Koszulki'),
(7, 1, 'Spodenki'),
(8, 1, 'Getry'),
(9, 2, 'Korki'),
(10, 2, 'Turfy'),
(11, 0, 'Kategoria testowa'),
(12, 0, 'Kategoria testowa 2'),
(13, 0, 'Kategoria testowa 3'),
(14, 3, 'Podakcesoria');

-- --------------------------------------------------------

--
-- Table structure for table `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `page_content` mediumtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `alias` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `alias`, `status`) VALUES
(1, 'Strona główna', '<div class=\"strona_glowna\">\n\n    <h3 class=\"tytul_h3\">\n        Piłka nożna – grać może każdy!\n    </h3>\n    <p class=\"opis\">\n        Piłka nożna to bezdyskusyjnie jeden z najpopularniejszych sportów drużynowych na świecie.\n        Cieszy się niezwykłym zainteresowaniem na praktycznie każdym kontynencie i bardzo trudno znaleźć osobę, która\n        chociaż raz nie zagrała w meczu w latach dzieciństwa.\n        Mistrzostwa Świata czy Europy w piłce nożnej to zawsze wielkie wydarzenie, a największe gwiazdy tego sportu\n        zarabiają krocie.\n        Jeśli szukasz najwyższej jakości sprzętu piłkarskiego – odzieży, butów, piłek oraz innych akcesoriów do piłki\n        nożnej – w naszym sklepie znajdziesz wyposażenie najwyższej jakości.\n        Z nim gra w piłkę nożną będzie jeszcze bardziej emocjonująca.\n    </p>\n    <br>\n\n    <h3 class=\"tytul_h3\">\n        Jak grać w piłkę nożną?\n    </h3>\n    <p class=\"opis\">\n        Każdy, kto chociaż raz zetknął się z piłką nożną wie, na czym polega ten sport. Pojedynek toczą dwa zespoły – w\n        każdej drużynie gra 11 zawodników, obrońcy, pomocnicy, napastnicy i bramkarz. Celem jest umieszczenie piłki w\n        bramce przeciwnika – brzmi banalnie prosto, ale wszyscy wiemy, że wcale nie takie nie jest. Mecze mają dwie\n        połowy – obie po 45 minut, przedzielone są przerwą. Kiedy nie uda się rozstrzygnąć meczu, a trzeba wyłonić\n        zwycięzcę (na przykład w turnieju) odbywa się 30-minutowa dogrywka, a jeśli i ona nie przyniesie zwycięstwa\n        żadnej z drużyn, to wykonuje się rzuty karne. Kto zdobędzie więcej trafień w cyklu, ten zwycięża.\n        Oczywiście to jedynie bardzo uproszczony opis gry w piłkę nożną, ale towarzyszące mu emocje robią wrażenie. Nic\n        dziwnego, że bez względu na płeć czy wiek lubimy od czasu do czasu sami zagrać. Czy to w amatorskich\n        rozgrywkach, czy na wyższym szczeblu, czy nawet grając we własnym ogródku. Wystarczą nam do tego dwa słupki,\n        piłka oraz oczywiście wygodny strój.\n    </p>\n    <br>\n\n    <h3 class=\"tytul_h3\">\n        Kto może grać w piłkę nożną?\n    </h3>\n    <p class=\"opis\">\n        Odpowiedź jest prosta – każdy. Nie liczy się płeć czy wiek – grają wszyscy, czasami nawet bez niezbędnego\n        stroju. Kiedy jednak chcemy uniknąć kontuzji czy urazów, lepiej odpowiednio się przygotować. Wygodne koszulki,\n        spodenki, a przede wszystkim buty sprawią, że gra będzie znacznie przyjemniejsza. Pamiętajmy, że najważniejsze\n        jest nasze bezpieczeństwo – najbardziej nawet emocjonująca gra zakończona kontuzją to nic dobrego, dlatego\n        wyposażenie się w dobre obuwie to podstawa. Dzięki temu nasza gra będzie także o wiele skuteczniejsza i będziemy\n        czuli się pewniej – zapraszamy więc do zaopatrzenia się w niezbędne akcesoria piłkarskie do naszego sklepu.\n        Znajdzie się odzież i sprzęt piłkarski dla dzieci i dorosłych, zawsze jednak wysokiej jakości. Gwarantujemy, że\n        oferowane przez nas ubrania i akcesoria do piłki nożnej przetrwają niejeden sezon, pomagając zdobyć upragnione\n        zwycięstwo na boisku.\n        Nie zwlekaj – już dziś wybierz odpowiedni sprzęt piłkarski i graj w piłkę!\n        Piłka nożna to uniwersalny sport – możne być uprawiany przez cały rok, czy to na hali, na boisku czy na plaży.\n        Bez względu na to gdzie jesteśmy, wystarczy zebrać grupę znajomych i piłkę i rozpocząć grę. Pomoże nam to w\n        trosce o kondycję, pozwoli poćwiczyć sprawność i dostarczy ruchu, o który coraz częściej bardzo trudno.\n        Wybierzmy odpowiednie akcesoria do piłki nożnej koszulkę, spodenki i buty, a także getry, ochraniacze i dres\n        oraz oczywiście piłkę – możemy nawet założyć własną drużynę i zgłosić ją do regionalnych rozgrywek. To świetny\n        sposób, by zyskać pasję, przyjaciół i zdrowie – czego więcej nam potrzeba?\n    </p>\n</div>', 'glowna', 1),
(2, 'Stroje piłkarskie', '<!DOCTYPE html>\n\n<div class=\"strona_glowna\">\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Real Madryt</h3>\n		<img src=\"img/koszulki/real_home.png\" class=\"obraz_przedmiotu\" alt=\"Real Madryt\">\n		<div class=\"opis_przedmiotu\">\n			Domowa koszulka Królewskich na sezon 2022/23 prezentuje się w tradycyjnych dla klubu barwach. Po ponad\n			dekadzie na koszulkach domowych, pojawił się kultowy biały kolor klubu z czernią i fioletem.\n			Charakterystycznym elementem jest to, że biel koszulki uzupełniona została fioletowymi wstawkami na\n			ramionach. Aby dopełnić klasyczny wygląd, klasyczny kołnierzyk polo ma wykończenia w kolorze fioletowym i\n			czarnym. Fioletowy strój Real Madryt po raz ostatni miał na wyjazdowych meczach w sezonie 2016/17, podczas\n			gdy ten kolor był regularnie używany w ich koszulkach domowych w latach 80. i 90. XX wieku.\n			W tylnej części kołnierzyka, od wewnętrznej strony, producent umieścił napis 120 años. Tym akcentem, adidas\n			przypomina wszystkim kibicom o 120 letniej historii klubu z Madrytu.\n			Nie można nie wspomnieć również o wyszywanym herbie klubu na lewej piersi. Logo adidas jest haftowane w\n			kolorze czarnym, a logo sponsora FLY BETTER na piersi zostało nadrukowane na koszulkę.\n			Adidas zmienił również technologię wykonywania koszulki. Przez lata używana była technologia Aeroready. W\n			tym sezonie, dzięki wdrożeniu technologii HEAT.RDY, będzie można poczuć jeszcze wyższą jakość noszenia.\n			Naszywka z kodem seryjnym u dołu oraz oryginalne metki są dowodem autentyczności – koszulki sprowadzamy\n			tylko z oficjalnego źródła.\n			Niezmiennie część piłkarskiej mody. Ta koszulka wyjazdowa adidas Real Madrid prezentuje świeże odcienie i\n			przyciągającą wzrok grafikę inspirowaną paskiem otaczającym klubową naszywkę. Model stworzony z myślą o\n			komforcie kibiców ma odprowadzający wilgoć AEROREADY i panele z siateczki. Wyszywana, monochromatyczna\n			wersja tej sławnej naszywki podkreśla Twoją dumę.\n			Ten produkt został wykonany w 100% z materiałów pochodzących z recyklingu i stanowi tylko jedno z naszych\n			rozwiązań, które pomogą wyeliminować zanieczyszczenie plastikiem.\n		</div>\n	</div>\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">FC Barcelona</h3>\n		<img src=\"img/koszulki/barcelona_home.png\" class=\"obraz_przedmiotu\" alt=\"FC Barcelona\">\n		<div class=\"opis_przedmiotu\">\n			Domowy trykot Dumy Katalonii na sezon 2022/23 będzie oparty na nowym modelu Nike 2022. Godne uwagi cechy\n			nowego modelu koszulki to nowy wzór Vaporknit i umiejscowienie logo Dri-Fit ADV, które znajduje się teraz na\n			plecach. Projekt trykotu był inspirowany Igrzyskami Olimpijskimi, które odbyły się w Barcelonie w 1992 roku,\n			a także transformacją, jakiej doświadczyło miasto. Tę inspirację widać znacznie wyraźniej w stroju\n			wyjazdowym, który ozdobiony jest wzorem wstążek medalowych olimpijskich sprzed 30 lat.\n			Producent wprowadza stylowy wygląd, dodając ciemnoniebieski do tradycyjnych pasków Blaugrany. Rękawy i\n			kołnierz koszulki Barçy są w jednolitym kolorze granatowym, a przód ma dość szerokie pasy w kolorze\n			granatowym, królewskim i czerwonym. Oficjalna nazwa granatu użytego w zestawie to „obsydian”, który jest\n			również kolorem logo na złotym zestawie wyjazdowym. Wewnątrz niebiesko-czerwonych pasków na przodzie domowej\n			koszulki znajduje się subtelny nadruk, który pojawi się również na różnej innej odzieży z kolekcji, w tym na\n			koszulce przedmeczowej.\n			W ostatnich latach, na piersi widniało logo Rakuten. Umowa w sezonie 21/22 wygasła, a Blaugrana znalazła\n			nowego popularnego sponsora – Spotify. Logo znanej marki muzycznej, będzie widnieć z przodu koszulki, w\n			złotym kolorze, takim samym co logo Nike.\n			Naszywka z kodem seryjnym u dołu oraz oryginalne metki są dowodem autentyczności – koszulki sprowadzamy\n			tylko z oficjalnego źródła.\n		</div>\n	</div>\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Manchester United</h3>\n		<img src=\"img/koszulki/mu_home.png\" class=\"obraz_przedmiotu\" alt=\"Manchester United\">\n		<div class=\"opis_przedmiotu\">\n			Domowy trykot drużyny z Old Trafford na sezon 2022/23 łączy w sobie ciemnoczerwony kolor, z białym logo\n			Adidas i trzema czarnymi paskami adidas na ramionach. To co wyróżnia ten projekt to kołnierz polo. Biały\n			kołnierzyk ma trójkątny wzór inspirowany 1994 rokiem.\n			Zestaw domowy Czerwonych Diabłów zawiera tarczę z logo Manchesteru United. Tarcza ma kształt pięciokąta z\n			nieco ciemniejszym odcieniem czerwieni niż reszta koszulki. Jest również obrysowany cienką obwódką, aby\n			oddzielić kształt. Ostatni raz herb Manchesteru United miał wokół siebie tarczę w 2019 roku, ale tym razem\n			kształt i kolor są inne. Nike zrobiło to w latach 2006-07. Graficzny „trójkątny” wzór zaprojektowany został\n			na samej koszulce, na kołnierzu.\n			Zmianie nie uległo logo sponsora generalnego Czerwonych Diabłów – na przodzie koszulki umieszczone zostało\n			logo Team Viewer. Zmiana nastąpiła na rękawku, tam widnieje logo DXC Technology zamiast logo Kohler.\n			Naszywka z kodem seryjnym u dołu oraz oryginalne metki są dowodem autentyczności – koszulki sprowadzamy\n			tylko z oficjalnego źródła.\n		</div>\n	</div>\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Manchester City</h3>\n		<img src=\"img/koszulki/mc_home.png\" class=\"obraz_przedmiotu\" alt=\"Manchester City\">\n		<div class=\"opis_przedmiotu\">\n			PUMA prezentuje najnowszą koszulkę z drużyny Manchester City FC , nową koszulkę treningową na sezon 22/23.\n			Posiada wygodną konstrukcję dopasowaną do ciała, która pozwala sportowcowi na łatwiejsze poruszanie się.\n			Ma prążkowany okrągły dekolt i prążkowane rękawy. Jest wykonana z poliestru w połączeniu z technologią\n			DryCell, która łatwo wchłania wilgoć i zapewnia chłód i suchość podczas treningu.\n			Na środku klatki piersiowej posiada logo producenta oraz insygnia MCFC.\n			Ich podania i ruch, od początku do końca ofensywny futbol po prostu wyprzedzał swój czas. Tak więc, kiedy\n			zdobyli każdy krajowy tytuł i uzupełnili go Pucharem Zdobywców Pucharów, zrobili to w sposób, który pół\n			wieku później inspiruje nowe pokolenie mieszczan, którzy nadal przesuwają granice w domu iw Europie. W tym\n			sezonie Manchester City FC i PUMA honorują zespół zawadiackich artystów i ich lidera: ikonę klubu Colina\n			Bella. Strój Manchester City FC Home na lata 2022/23 nawiązuje do klasycznych projektów swojej epoki,\n			umieszczając herb klubu na środku i bordowe wykończenia na mankietach rękawów. Logo z koroną wewnątrz\n			dekoltu to hołd dla „Króla Colina”.\n		</div>\n	</div>\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Liverpool</h3>\n		<img src=\"img/koszulki/liverpool_home.png\" class=\"obraz_przedmiotu\" alt=\"Liverpool\">\n		<div class=\"opis_przedmiotu\">\n			Domowy trykot Liverpoolu na sezon 2022/23 ma bardzo prosty i stonowany wzór w kolorze czerwonym, bez żadnych\n			grafik i wykończeń, z samymi logo w kolorze białym.\n			Główny kolor koszulki jest nieco ciemniejszy niż w poprzednim sezonie, co dobrze współgra z ogólną estetyką.\n			Zgodnie z tradycją, na tylnej części kołnierza znajdziemy emblemat upamiętniający 97 rocznicę ofiar tragedii\n			na Hillsborough. Subtelny detal można zobaczyć na mankietach rękawów - mają one wzór graficzny YNWA.\n			Na froncie koszulki widnieje logo Standard Chartered, a na lewym rękawku pojawił się sponsor – Expedia.\n			Czyli tak samo jak w przypadku koszulki na sezon 2021/22.\n			Naszywka z kodem seryjnym u dołu oraz oryginalne metki są dowodem autentyczności – koszulki sprowadzamy\n			tylko z oficjalnego źródła.\n		</div>\n	</div>\n</div>', 'stroje', 1),
(3, 'Obuwie piłkarskie (korki)', '<div class=\"strona_glowna\">\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Nike Phantom GT2 Elite SG-Pro</h3>\n		<img src=\"img/obuwie/nike_phantom_GT2_elite_SG-PRO.png\" class=\"obraz_przedmiotu\"\n			alt=\"Nike Phantom GT2 Elite SG-Pro\">\n		<div class=\"opis_przedmiotu\">\n			Model Nike Phantom GT2 Elite SG-Pro czerpie inspirację z modelu Phantom GT. Wyróżnia się nowym fasonem i\n			wypukłym wzorem, dzięki czemu pozwala jeszcze lepiej kontrolować lot piłki. Boczne wiązanie zapewnia\n			doskonałą strefę kontaktu z piłką, co przekłada się na większą precyzję podczas strzałów, podań i\n			dryblingów.\n			Technologia All Conditions Control (ACC) umożliwia czucie piłki zarówno na suchej, jak i mokrej nawierzchni.\n			Sprawia też, że panowanie nad futbolówką jest jeszcze prostsze dzięki stałym właściwościom powierzchni buta.\n			Konstrukcja Flyknit składa się z otaczających stopę elastycznych włókien przędzy, które odpowiadają za\n			lekkość i dokładne dopasowanie. Zapewnia to wsparcie, którego potrzebujesz, aby szybko mijać przeciwników.\n			Strategicznie umiejscowiona czepliwa tekstura na cholewce zapewnia precyzyjne czucie piłki przy podaniach,\n			strzałach i dryblingu.\n		</div>\n	</div>\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Nike Mercurial Superfly 8 Elite SG-Pro</h3>\n		<img src=\"img/obuwie/nike_mercurial_superfly_8_elite_sg-pro.png\" class=\"obraz_przedmiotu\"\n			alt=\"Nike Mercurial Superfly 8 Elite SG-Pro\">\n		<div class=\"opis_przedmiotu\">\n			Odblokuj plan szybkości dzięki butom Nike Mercurial Superfly 8 Elite.\n			Płytka Nike Aerotrak z mikrorowkami zapewnia wybuchowe przyspieszenie.\n			Kołki Chevron zapewniają wielokierunkową przyczepność na mokrych nawierzchniach.\n			Konstrukcja Flyknit otula kostkę oddychającą, elastyczną przędzą, zapewniając dopasowanie jak w skarpetce.\n			Technologia NikeGrip we wkładce wykorzystuje przędzę antypoślizgową, która zapobiega ślizganiu się stopy\n			wewnątrz buta.\n		</div>\n	</div>\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Nike Mercurial Superfly 9 Elite SG-Pro</h3>\n		<img src=\"img/obuwie/nike_mercurial_superfly_9_elite_sg-pro.png\" class=\"obraz_przedmiotu\"\n			alt=\"Nike Mercurial Superfly 9 Elite SG-Pro\">\n		<div class=\"opis_przedmiotu\">\n			Zmień warunki gry dzięki wyrazistemu fasonowi butów Superfly 9 Elite SG-Pro. Wykorzystaliśmy w nich poduszkę\n			gazową Zoom Air, stworzoną specjalnie z myślą o piłce nożnej, oraz czepliwą fakturę na wierzchu, która\n			zapewnia niespotykane czucie piłki, dzięki czemu możesz dać z siebie wszystko także w tych ostatnich,\n			decydujących minutach meczu. Poczuj wybuchową szybkość na boisku i rozgrywaj piłkę z prędkością błyskawicy.\n			Fast is in the Air. Zastosowana w tej wersji technologia Anti-Clog Traction w płytce podeszwowej chroni\n			przed przywieraniem błota.\n			Witamy na boisku, Zoom\n			Po raz pierwszy w historii firma Nike opracowała zupełnie nową, stworzoną specjalnie do gry w piłkę nożną\n			poduszkę gazową Zoom Air, która rozciąga się na 3/4 długości buta. Została umieszczona w płytce, daje\n			jeszcze lepsze czucie sprężystości oraz pozwala szybciej poruszać się po boisku i znaleźć wolną przestrzeń w\n			najważniejszych momentach meczu, by zdobyć bramkę czy uciec obrońcom.\n			Zwiększ swoją szybkość\n			Wzmocnienie odpowiadające za prędkość, umieszczone wewnątrz całej konstrukcji, jest wykonane z cienkiego,\n			ale mocnego materiału, który utrzymuje stopę przy podeszwie zewnętrznej i zapewnia optymalne dopasowanie bez\n			zbędnego obciążenia.\n			Zakotwicz się i ruszaj\n			Metalowe korki na podeszwie zewnętrznej zapewniają niezrównaną przyczepność i umożliwiają szybkie oderwanie\n			butów od podłoża.\n			Jeszcze lepsze dopasowanie\n			Miękki i rozciągliwy materiał Flyknit otula kostkę oraz zapewnia dokładne dopasowanie. Udoskonalony fason\n			charakteryzuje się lepszym dopasowaniem wokół stopy. Osiągnęliśmy ten rezultat dzięki zaangażowaniu setek\n			sportowców testujących nasz produkt. Pozwoliło nam to uzyskać lepiej wyprofilowany nosek i bardziej\n			dopasowany zapiętek.\n			Poczuj piłkę\n			Cholewka jest wykonana z materiału Vaporposite, który łączy w sobie czepliwą siateczkę z materiałem\n			najwyższej jakości, dzięki czemu zapewnia optymalną kontrolę nad piłką przy dużych prędkościach. Materiał\n			sprawia, że cała powierzchnia cholewki jest przyjemna w dotyku. Dokładnie i miękko otula stopę, a\n			jednocześnie ją stabilizuje, co przekłada się na bardziej naturalne czucie piłki podczas dryblingów, podań\n			czy strzałów na bramkę.\n		</div>\n	</div>\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Adidas Predator Edge+ SG</h3>\n		<img src=\"img/obuwie/adidas_predator_edge_sp.png\" class=\"obraz_przedmiotu\" alt=\"Adidas Predator Edge+ SG\">\n		<div class=\"opis_przedmiotu\">\n			Buty piłkarskie, które pomogą Ci kontrolować każdą składową gry.\n			Unik. Moc. Kontrola. Gdy masz przewagę, boisko jest pełne możliwości. Zobacz piękną grę z zupełnie nowej\n			perspektywy w butach adidas Predator. Te buty piłkarskie bez sznurowadeł pomogą Ci strzelać gole dzięki\n			cholewce Zone Skin, która ma ukryte, prążkowane sekcje rozmieszczone i ukształtowane tak, aby umożliwić\n			zawodnikowi różne rodzaje kontaktu z piłką. Wyważona konstrukcja Power Facet w dzielonej podeszwie\n			zewnętrznej w przedniej części stopy dodaje mocy każdemu uderzeniu. Elastyczny kołnierz adidas PRIMEKNIT\n			blokuje stopę, gdy zyskujesz coraz większą kontrolę nad przebiegiem gry.\n		</div>\n	</div>\n\n	<div class=\"przedmiot\">\n		<h3 class=\"tytul_h3\">Adidas X Speedportal.1 AG</h3>\n		<img src=\"img/obuwie/adidas_x_speedportal_1_AG.png\" class=\"obraz_przedmiotu\" alt=\"Adidas X Speedportal.1 AG\">\n		<div class=\"opis_przedmiotu\">\n			Dynamiczne buty adidas wykonane częściowo z materiałów pochodzących z recyklingu.\n			Dobrzy zawodnicy potrafią znaleźć dobrą okazję. Wybitni zawodnicy sami je tworzą. Wkrocz do świata\n			wielowymiarowej szybkości w butach adidas X Speedportal. Gładkie i superwygodne buty piłkarskie wspierają\n			błyskawiczne reakcje dzięki sprężystej płytce Carbitex z włókna węglowego na całej długości podeszwy\n			zewnętrznej przystosowanej do gry na sztucznej trawie. Otulająca stopę cholewka adidas PRIMEKNIT ma wstawki\n			z pianki EVA po wewnętrznej stronie i lekką, węglową blokadę pięty po zewnętrznej stronie, która zapewnia Ci\n			stabilizację podczas szybkiej gry.\n			Czasy, gdy szybkość oznaczała pokonanie jakiegoś dystansu w jakimś czasie, należą już do przeszłości.\n			Reakcja, świadomość, myślenie, ruch – mówimy o szybkości we wszystkich możliwych wymiarach. Wypróbuj nowe X\n			Speedportal; niech Twoje stopy nawiążą kontakt z Twoją świadomością i szybkością myślenia. Speedframe,\n			system stabilizujący i Speedskin pomagają połączyć umysł, ciało i... but. Dzięki temu jesteś w stanie\n			odblokować szybkość we wszystkich wymiarach.\n		</div>\n	</div>\n</div>', 'obuwie', 1),
(4, 'Rękawice bramkarskie', '<div class=\"strona_glowna\">\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Adidas Predator Pro</h3>\r\n		<img src=\"img/rekawice/adidas_predator_pro.png\" class=\"obraz_przedmiotu\" alt=\"Adidas Predator Pro\">\r\n		<div class=\"opis_przedmiotu\">\r\n			Znajdź przewagę bramkarską w tych rękawicach piłkarskich bez pasków.\r\n			Odkryj zupełnie nową stronę swojej gry. Te rękawice bramkarskie adidas Predator Edge mają silikonową powłokę\r\n			Zone Skin na dopasowującym się grzbiecie dłoni z dzianiny, która zwiększa kontrolę nad piłką przy szybkich\r\n			wybiciach. Wewnętrzna część dłoni URG 2.0 zapewnia lepszą przyczepność i amortyzację. Kompresyjny otwór bez\r\n			pasków odpowiada za naturalne dopasowanie, które pozwoli Ci się skoncentrować.\r\n			Wewnętrzna część dłoni URG 2.0 zapewnia lepszą przyczepność i amortyzację. Kompresyjny otwór bez pasków\r\n			odpowiada za naturalne dopasowanie, które pozwoli Ci się skoncentrować.\r\n		</div>\r\n	</div>\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Adidas X Speedportal Pro</h3>\r\n		<img src=\"img/rekawice/adidas_x_speedportal_pro.png\" class=\"obraz_przedmiotu\" alt=\"Adidas X Speedportal Pro\">\r\n		<div class=\"opis_przedmiotu\">\r\n			Idealnie dopasowane rękawice bramkarskie wykonane z mieszanki materiałów pochodzących z recyklingu i\r\n			odnawialnych źródeł.\r\n			Odkryj nowy wymiar zwinności. Rękawice bramkarskie adidas X Speedportal zapewnią Ci szybkość dzięki\r\n			lekkiemu, opływowemu designowi. Elastyczny grzbiet dłoni bez pasków umożliwia bezpieczne dopasowanie dzięki\r\n			mankietowi o specjalnej konstrukcji, który dokładnie przylega w nadgarstku. Lateksowa wewnętrzna część dłoni\r\n			URG 2.0 ułatwia pewny chwyt piłki i amortyzuje uderzenia. W środku antypoślizgowy silikon sprawia, że jesteś\r\n			jednym z rękawiczkami.\r\n			Co najmniej 50% tego produktu to mieszanka materiałów pochodzących z recyklingu i surowców odnawialnych.\r\n		</div>\r\n	</div>\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Adidas Predator Pro Hybrid Fingersave</h3>\r\n		<img src=\"img/rekawice/adidas_predator_pro_finger_support.png\" class=\"obraz_przedmiotu\"\r\n			alt=\"Adidas Predator Pro Hybrid Fingersave\">\r\n		<div class=\"opis_przedmiotu\">\r\n			Znajdź przewagę bramkarską w tych wzmocnionych rękawicach piłkarskich.\r\n			Odkryj zupełnie nową stronę swojej gry. Te rękawice bramkarskie adidas Predator Edge mają silikonową powłokę\r\n			Zone Skin na grzbiecie dłoni, która zwiększa kontrolę przy wybiciu piłki i wspiera palce, gwarantując pewny\r\n			chwyt i rzut. Wewnętrzna część dłoni URG 2.0 zapewnia lepszą przyczepność i amortyzację. Kompresyjny otwór\r\n			bez pasków odpowiada za naturalne dopasowanie, które pozwoli Ci się skoncentrować.\r\n		</div>\r\n	</div>\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Nike Mercurial Touch Elite</h3>\r\n		<img src=\"img/rekawice/nike_mercurial_touch_elite.png\" class=\"obraz_przedmiotu\"\r\n			alt=\"Nike Mercurial Touch Elite\">\r\n		<div class=\"opis_przedmiotu\">\r\n			W rękawicach bramkarskich Nike Mercurial Touch Elite Twoje interwencje na boisku są szybkie i bezbłędne.\r\n			Prestiżowy projekt dopełniony logo brandu. Elastyczny pasek wokół nadgarstka zapewnia bezpieczne\r\n			dopasowanie. Klin z odwróconymi szwami oplata dłonie, zapewniając naturalne dopasowanie. Odwrócone szwy na\r\n			klinie zapewniają wygodny chwyt. Perforowana siateczka daje lekkość i przewiewność. Technologia ACC zapewnia\r\n			kontrolę nad piłką zarówno w suchych, jak i mokrych warunkach.\r\n		</div>\r\n	</div>\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Nike Phantom Elite</h3>\r\n		<img src=\"img/rekawice/nike_phantom_elite.png\" class=\"obraz_przedmiotu\" alt=\"Nike Phantom Elite\">\r\n		<div class=\"opis_przedmiotu\">\r\n			DOSKONAŁE BRONIENIE DZIĘKI ELASTYCZNOŚCI I PRZYCZEPNOŚCI.\r\n			Rękawice Phantom Elite Goalkeeper mają trwałą piankę, która blokuje strzały. Elastyczny materiał umożliwia\r\n			wygodne poruszanie dłońmi. Technologia All Conditions Control (ACC) zapewnia doskonałą przyczepność zarówno\r\n			w wilgotnych, jak i suchych warunkach.\r\n			Technologia All Conditions Control (ACC) zapewnia doskonałą przyczepność zarówno w wilgotnych, jak i suchych\r\n			warunkach.\r\n			Elastyczny neopren z amortyzacją na grzbiecie dłoni umożliwia wykonywanie naturalnych ruchów.\r\n			Kliny z siateczki między palcami zapewniają przewiewność.\r\n			Wydłużona część osłaniająca nadgarstek ma klin ułatwiający zakładanie i zdejmowanie.\r\n		</div>\r\n	</div>\r\n</div>', 'rekawice', 1),
(5, 'Piłki', '<div class=\"strona_glowna\">\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Adidas Al Rihla 2022 PRO ROZMIAR 5</h3>\r\n		<img src=\"img/pilki/adidas_al_rihla.png\" class=\"obraz_przedmiotu\" alt=\"Adidas Al Rihla 2022 PRO ROZMIAR 5\">\r\n		<div class=\"opis_przedmiotu\">\r\n			Najnowsza piłka meczowa zaprojektowana specjalnie na Mistrzostwa Świata FIFA™ 2022 w Katarze. Żywa i perłowa\r\n			grafika wzorowana flagą Kataru oraz tradycyjną odzieżą arabską nadaje świetny efekt wizualny.\r\n			W piłce znajduje się gumowy pęcherz, dzięki czemu powietrze utrzymuje się dłużej niezależnie od miejsca\r\n			użytkowania. Zgrzewany termicznie materiał wykonany został z pianki z trzciny cukrowej i spienionego\r\n			kauczuku. Piłka została wyposażona w nowoczesną technologię Speedshell zapewniającą znakomitą aerodynamikę i\r\n			perfekcyjny strzał. Liczne diamentowe wytłoczenia gwarantują większą zwrotność oraz precyzję. Piłka\r\n			sygnowana jest oficjalnym logiem Mistrzostw Świata FIFA™ oraz posiada certyfikat FIFA Quality PRO co\r\n			sprawia, że jest to produkt najwyższej jakości. Zapakowana w kartonik idealnie sprawdzi się jako prezent.\r\n		</div>\r\n	</div>\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Adidas UEFA Nations Leauge PRO ROZMIAR 5</h3>\r\n		<img src=\"img/pilki/adidas_ufea_nations_leauge_pro.png\" class=\"obraz_przedmiotu\"\r\n			alt=\"Adidas UEFA Nations Leauge PRO ROZMIAR 5\">\r\n		<div class=\"opis_przedmiotu\">\r\n			BEZSZWOWA OFICJALNA PIŁKA MECZOWA LIGI NARODÓW UEFA.\r\n			Zjednoczony kontynent. Grafiki na piłce adidas UEFA Nations League Pro przyciągają wzrok efektem rozmycia w\r\n			kolorach europejskiej rodziny piłkarskiej. Pod inspirowanym flagą designem kryje się bezszwowa powłoka,\r\n			która zapewnia przewidywalną grę, a butylowy pęcherz oznacza, że modelu nie trzeba tak często dopompowywać.\r\n			Znak jakości Quality Pro to najwyższa ocena FIFA.\r\n		</div>\r\n	</div>\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Select Derbystar Bundesliga Brillant APS FIFA PRO V22 ROZMIAR 5</h3>\r\n		<img src=\"img/pilki/select_derbystar_bundesliga_brillant_aps.png\" class=\"obraz_przedmiotu\"\r\n			alt=\"Select Derbystar Bundesliga Brillant APS FIFA PRO V22 ROZMIAR 5\">\r\n		<div class=\"opis_przedmiotu\">\r\n			Przedstawiamy oficjalną piłkę meczową Bundesligi na sezon 2022/2023, która będzie używana przez 36 klubów\r\n			Bundesligi i 2. Bundesligi rywalizować będą, nową futbolówką Derbystar.\r\n			Futbolówka została wykonana z najwyższej jakości materiałów. Jej charakterystyczna struktura poprawia\r\n			prowadzenie piłki zwiększając tym samym pewność gracza na boisku, a kontrastowe kolory poprawiają jej\r\n			widoczność.\r\n			W piłce Derbystar APS FIFA PRO zastosowano nowoczesną metodę podwójnego łączenia wyróżniającą się tym, że\r\n			panele piłki są najpierw zszywane ze sobą, a następnie sklejane na krawędziach. Dzięki zastosowaniu kleju do\r\n			uszczelniania szwów pochłanianie wody zostaje znacznie ograniczone. Pęcherz SR wewnątrz piłki zapewnia\r\n			doskonałe utrzymywanie powietrza. Efektem końcowym jest piłka nożna wyróżniająca się spośród innych piłek\r\n			stabilnością, znakomitym prowadzeniem i lekkim wyglądem.\r\n		</div>\r\n	</div>\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Nike Premier Leauge Flight ROZMIAR 5</h3>\r\n		<img src=\"img/pilki/nike_premier_leauge_flight.png\" class=\"obraz_przedmiotu\"\r\n			alt=\"Nike Premier Leauge Flight ROZMIAR 5\">\r\n		<div class=\"opis_przedmiotu\">\r\n			Udoskonalana przez 8 lat i 1700 godzin testów piłka Nike Flight Soccer Ball to rewolucja w konsekwentnym\r\n			locie. Profilowane rowki i przyczepna tekstura ograniczają nieoczekiwane ruchy w powietrzu, pomagając\r\n			umieścić piłkę tam, gdzie chcesz.\r\n			Technologia Nike Aerowsculpt wykorzystuje uformowane rowki, które zakłócają przepływ powietrza przez piłkę,\r\n			zapewniając mniejszy opór i bardziej stabilny lot. Nakładka z atramentem drukowana w 3D precyzyjnie dostraja\r\n			lot piłki, aby pomóc Ci trafić w cel strzał za strzałem, podanie za podaniem.\r\n			Technologia All Conditions Control (ACC) zapewnia przyczepną teksturę zarówno w mokrych, jak i suchych\r\n			warunkach.\r\n		</div>\r\n	</div>\r\n\r\n	<div class=\"przedmiot\">\r\n		<h3 class=\"tytul_h3\">Adidas UCL PRO ROZMIAR 5</h3>\r\n		<img src=\"img/pilki/adidas_ucl_pro.png\" class=\"obraz_przedmiotu\" alt=\"Adidas UCL PRO ROZMIAR 5\">\r\n		<div class=\"opis_przedmiotu\">\r\n			Udoskonalana przez 8 lat i 1700 godzin testów piłka Nike Flight Soccer Ball to rewolucja w konsekwentnym\r\n			locie. Profilowane rowki i przyczepna tekstura ograniczają nieoczekiwane ruchy w powietrzu, pomagając\r\n			umieścić piłkę tam, gdzie chcesz.\r\n			Technologia Nike Aerowsculpt wykorzystuje uformowane rowki, które zakłócają przepływ powietrza przez piłkę,\r\n			zapewniając mniejszy opór i bardziej stabilny lot. Nakładka z atramentem drukowana w 3D precyzyjnie dostraja\r\n			lot piłki, aby pomóc Ci trafić w cel strzał za strzałem, podanie za podaniem.\r\n			Technologia All Conditions Control (ACC) zapewnia przyczepną teksturę zarówno w mokrych, jak i suchych\r\n			warunkach.\r\n		</div>\r\n	</div>\r\n\r\n</div>', 'pilki', 1),
(6, 'Filmy', '<div class=\"strona_glowna\">\r\n\r\n    <div class=\"przedmiot\">\r\n        <h3 class=\"tytul_h3\">Porównanie tanich butów piłkarskich do tych z wyższej półki</h3>\r\n        <div class=\"opis_przedmiotu\">\r\n            <iframe style=\"display:block;margin-left:auto;margin-right:auto;\" width=\"560\" height=\"315\"\r\n                src=\"https://www.youtube.com/embed/LNNupCyWG1Q\" title=\"YouTube video player\" frameborder=\"0\"\r\n                allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\"\r\n                allowfullscreen></iframe>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"przedmiot\">\r\n        <h3 class=\"tytul_h3\">Porównanie zwykłych piłek do piłek meczowych</h3>\r\n        <div class=\"opis_przedmiotu\">\r\n            <iframe style=\"display:block;margin-left:auto;margin-right:auto;\" width=\"560\" height=\"315\"\r\n                src=\"https://www.youtube.com/embed/-SmKVsvC6oM\" title=\"YouTube video player\" frameborder=\"0\"\r\n                allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\"\r\n                allowfullscreen></iframe>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"przedmiot\">\r\n        <h3 class=\"tytul_h3\">Top 5 najlepszych rękawic bramkarskich w 2022 r.</h3>\r\n        <div class=\"opis_przedmiotu\">\r\n            <iframe style=\"display:block;margin-left:auto;margin-right:auto;\" width=\"560\" height=\"315\"\r\n                src=\"https://www.youtube.com/embed/4OnxLC_JEDA\" title=\"YouTube video player\" frameborder=\"0\"\r\n                allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\"\r\n                allowfullscreen></iframe>\r\n        </div>\r\n    </div>\r\n\r\n</div>', 'filmy', 1),
(7, 'Kontakt', '<form name=\"form_kontaktowy\" action=\"mailto:162686@student.uwm.edu.pl\" method=\"POST\"\r\n	onload=\"wyczysc_inputy(form_kontaktowy)\">\r\n	<div class=\"formularz_kontaktowy\">\r\n\r\n		<label class=\"label_kontakt\" for=\"input_imie_i_nazwisko\">Imię i nazwisko:</label>\r\n		<input id=\"input_imie_i_nazwisko\" type=\"text\" placeholder=\"Wprowadź dane\">\r\n\r\n		<label class=\"label_kontakt\" for=\"input_wiadomosc\">Wiadomość:</label>\r\n		<textarea id=\"input_wiadomosc\" placeholder=\"Wprowadź wiadomość\"></textarea>\r\n\r\n		<div class=\"przyciski\">\r\n			<span id=\"przycisk_span_lewy\">\r\n				<label class=\"przycisk_label_kontakt\" for=\"button_przeslij\">Prześlij wiadomość:</label>\r\n				<button id=\"przycisk\" type=\"submit\">Prześlij</button>\r\n			</span>\r\n\r\n			<span id=\"przycisk_span_prawy\">\r\n				<label class=\"przycisk_label_kontakt\" for=\"wyczysc\">Wyczyść pola:</label>\r\n				<button id=\"przycisk\" type=\"button\" onclick=\"wyczysc_inputy(form_kontaktowy)\">Wyczyść</button>\r\n			</span>\r\n		</div>\r\n\r\n		<label id=\"footer\" style=\"color:white\" onclick=\"changeBackground()\"> <i> <u>Wiadomość zostanie do mnie\r\n					dostarczona mailem</u> </i> </label>\r\n	</div>\r\n</form>', 'kontakt', 1),
(14, 'test', 'test', 'test', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;