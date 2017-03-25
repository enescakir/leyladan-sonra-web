<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Child, App\Faculty, App\User, App\Post, App\PostImage, App\Process, App\Feed, App\Notification;
use App\Social, App\SocialImage, App\Volunteer;
use Auth, Carbon\Carbon, DB, File, Log, Mail, Datatables, Image, Session;
use App\Http\Requests\CreateChildRequest;

use Illuminate\Support\Str;

//use App\Http\Requests\NewChildRequest;


class ChildController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.child.index');
    }

    public function indexData()
    {
        return Datatables::of(Child::select('id','faculty_id','department', 'diagnosis', 'first_name','last_name','wish','birthday','meeting_day','gift_state')->with('faculty')->get())
            ->editColumn('operations', '
                                        <a class="edit btn btn-primary btn-sm" href="{{ route("admin.child.show", $id) }}"><i class="fa fa-search"></i></a>
                                        <a class="edit btn btn-success btn-sm" href="{{ route("admin.child.edit", $id) }}"><i class="fa fa-pencil"></i></a>
                                        <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>')
            ->editColumn('gift_state',' @if ($gift_state == "Bekleniyor")
                                        <td><span class="label label-danger"> Bekleniyor </span></td>
                                    @elseif ($gift_state == "Yolda")
                                        <td><span class="label label-warning"> Yolda </span></td>
                                    @elseif ($gift_state == "Bize Ulaştı")
                                        <td><span class="label label-primary"> Bize Ulaştı </span></td>
                                    @elseif ($gift_state == "Teslim Edildi")
                                        <td><span class="label label-success"> Teslim Edildi </span></td>
                                    @else
                                        <td><span class="label label-default"> Problem </span></td>
                                    @endif')
            ->editColumn('birthday','{{date("d.m.Y", strtotime($birthday))}}')
            ->editColumn('meeting_day','{{date("d.m.Y", strtotime($meeting_day))}}')
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authUser = Auth::user();
        $faculties = Faculty::all();
        $users = User::select('id', DB::raw('CONCAT(first_name, " ", last_name) AS fullname2'), 'faculty_id')->where('faculty_id',$authUser->faculty_id)->orderby('first_name')->lists('fullname2', 'id');
        $diagnosis = [
          '' => '',
          'AADC Eksikliği' => 'AADC Eksikliği',
          'ADA Eksikliği' => 'ADA Eksikliği',
          'ADEM (Akut Dissemine Ensefalomiyelit)' => 'ADEM (Akut Dissemine Ensefalomiyelit)',
          'Adrenal Bez Konjenital Malformasyon' => 'Adrenal Bez Konjenital Malformasyon',
          'Adrenal Yetmezliği' => 'Adrenal Yetmezliği',
          'Adrenokortikal Karsinom' => 'Adrenokortikal Karsinom',
          'Afibrinojemi' => 'Afibrinojemi',
          'Ailevi Akdeniz Ateşi - FMF' => 'Ailevi Akdeniz Ateşi - FMF',
          'Akciğer İmmun Yetmezliği' => 'Akciğer İmmun Yetmezliği',
          'Akciğer Kanseri' => 'Akciğer Kanseri',
          'Akciğer Kisti' => 'Akciğer Kisti',
          'Akciğerde Emboli' => 'Akciğerde Emboli',
          'Akdeniz Anemisi (Talasemi)' => 'Akdeniz Anemisi (Talasemi)',
          'Akondroplazi' => 'Akondroplazi',
          'Akut Romatizmal Ateş' => 'Akut Romatizmal Ateş',
          'Akut Romatizmal Miyokardit' => 'Akut Romatizmal Miyokardit',
          'Alagille' => 'Alagille',
          'Alerjik Astım' => 'Alerjik Astım',
          'Alveolar Rabdomyosarkom' => 'Alveolar Rabdomyosarkom',
          'Anaplastik Astrositom' => 'Anaplastik Astrositom',
          'Anaplastik Ependimom' => 'Anaplastik Ependimom',
          'Anjiosarkom' => 'Anjiosarkom',
          'Anoreksiya Nervoza' => 'Anoreksiya Nervoza',
          'Aort Koarktasyonu' => 'Aort Koarktasyonu',
          'Aplastik Anemi' => 'Aplastik Anemi',
          'Arterit' => 'Arterit',
          'Artrit' => 'Artrit',
          'ASD' => 'ASD',
          'ASD-VSD' => 'ASD-VSD',
          'Astım' => 'Astım',
          'Astım Bronşit' => 'Astım Bronşit',
          'Astrositom' => 'Astrositom',
          'Ataksi Telenjektazi' => 'Ataksi Telenjektazi',
          'Atelektazi' => 'Atelektazi',
          'Atipik Teratoid Rabdoid Tümör' => 'Atipik Teratoid Rabdoid Tümör',
          'Bartter Sendromu' => 'Bartter Sendromu',
          'Behçet Hastalığı' => 'Behçet Hastalığı',
          'Berrak Hücreli Sarkom' => 'Berrak Hücreli Sarkom',
          'Beta Talasemi' => 'Beta Talasemi',
          'Beyin Absesi' => 'Beyin Absesi',
          'Beyin Ödemi' => 'Beyin Ödemi',
          'Beyin Sapı Tümörü' => 'Beyin Sapı Tümörü',
          'Beyin Tümörü' => 'Beyin Tümörü',
          'Beyincik Tümörü' => 'Beyincik Tümörü',
          'Bilier Atrezi' => 'Bilier Atrezi',
          'Boyun Tümörü' => 'Boyun Tümörü',
          'Böbrek Kanseri' => 'Böbrek Kanseri',
          'Böbrek Taşı' => 'Böbrek Taşı',
          'Böbrek Tümörü' => 'Böbrek Tümörü',
          'Böbrek Üstü Bezi Tümörü' => 'Böbrek Üstü Bezi Tümörü',
          'Böbrek Yetmezliği' => 'Böbrek Yetmezliği',
          'Böbrek Yetmezliği ve Organ nakli' => 'Böbrek Yetmezliği ve Organ nakli',
          'Böbrekte Üreteropelvik Darlık' => 'Böbrekte Üreteropelvik Darlık',
          'Bronşektazi' => 'Bronşektazi',
          'Bronşiolitis Obliterans' => 'Bronşiolitis Obliterans',
          'Burkitt Lenfoma' => 'Burkitt Lenfoma',
          'Bülloz Pemfigoid' => 'Bülloz Pemfigoid',
          'Büyüme ve Gelişme Geriliği' => 'Büyüme ve Gelişme Geriliği',
          'Cam Kemik Hastalığı (Osteogenezis İmperfekta)' => 'Cam Kemik Hastalığı (Osteogenezis İmperfekta)',
          'Canavan Hastalığı' => 'Canavan Hastalığı',
          'Clear Cell Sarkom' => 'Clear Cell Sarkom',
          'Crohn Sendromu' => 'Crohn Sendromu',
          'Cutis Laxa Sendromu' => 'Cutis Laxa Sendromu',
          'Çift Toplamalı Sistem' => 'Çift Toplamalı Sistem',
          'Çok Uzun Zincirli Yağ Asidi Oksidasyonu Defekti' => 'Çok Uzun Zincirli Yağ Asidi Oksidasyonu Defekti',
          'Çölyak Hastalığı' => 'Çölyak Hastalığı',
          'Dermatomiyozit' => 'Dermatomiyozit',
          'Diabetes İnsipidus' => 'Diabetes İnsipidus',
          'Diabetes Mellitus' => 'Diabetes Mellitus',
          'Diamond Blackfan anemisi' => 'Diamond Blackfan anemisi',
          'Dilate Kardiyomiyopati' => 'Dilate Kardiyomiyopati',
          'Disgerminom' => 'Disgerminom',
          'Distal Renal Tübül Asidoz' => 'Distal Renal Tübül Asidoz',
          'Down Sendromu' => 'Down Sendromu',
          'Duchenne Musküler Distrofi' => 'Duchenne Musküler Distrofi',
          'Eklem Romatizması' => 'Eklem Romatizması',
          'Ekstremite Arterlerinin Embolizm ve Trombozu' => 'Ekstremite Arterlerinin Embolizm ve Trombozu',
          'Embriyonel Rabdomiyosarkom' => 'Embriyonel Rabdomiyosarkom',
          'Endokardit' => 'Endokardit',
          'Ensefalit' => 'Ensefalit',
          'Ependimom' => 'Ependimom',
          'Epidural Kanama' => 'Epidural Kanama',
          'Epilepsi' => 'Epilepsi',
          'Evans Sendromu' => 'Evans Sendromu',
          'Ewing Sarkomu' => 'Ewing Sarkomu',
          'Fallot Tetralojisi' => 'Fallot Tetralojisi',
          'Fanconi Aplastik Anemisi' => 'Fanconi Aplastik Anemisi',
          'Fanconi Sendromu' => 'Fanconi Sendromu',
          'Fokal Segmentel Glomerulonefrit' => 'Fokal Segmentel Glomerulonefrit',
          'Fruktoz 1,6-bifosfataz eksikliği' => 'Fruktoz 1,6-bifosfataz eksikliği',
          'Germ Hücreli Tümör' => 'Germ Hücreli Tümör',
          'Germinom' => 'Germinom',
          'Gırtlak Kanseri' => 'Gırtlak Kanseri',
          'Glanzman Trombastenisi' => 'Glanzman Trombastenisi',
          'Glikojen Depo Hastalığı' => 'Glikojen Depo Hastalığı',
          'Glioblastoma' => 'Glioblastoma',
          'Glomerülonefrit' => 'Glomerülonefrit',
          'Göz Tümörü' => 'Göz Tümörü',
          'Granülositik Sarkom' => 'Granülositik Sarkom',
          'Guillain Barre Sendromu (GBS)' => 'Guillain Barre Sendromu (GBS)',
          'HBS (Huzursuz Bacak Sendromu)' => 'HBS (Huzursuz Bacak Sendromu)',
          'Hemanjiyom' => 'Hemanjiyom',
          'Hematogastrik Lenfohistiasitoz' => 'Hematogastrik Lenfohistiasitoz',
          'Hemofagositik Lenfohistiositoz' => 'Hemofagositik Lenfohistiositoz',
          'Hemofagositik Sendrom' => 'Hemofagositik Sendrom',
          'Hemofili' => 'Hemofili',
          'Hemofili A' => 'Hemofili A',
          'Hemofili B' => 'Hemofili B',
          'Hemolitik Anemi' => 'Hemolitik Anemi',
          'Hemolitik Üremik Sendrom' => 'Hemolitik Üremik Sendrom',
          'Henoch Schönlein Purpurası' => 'Henoch Schönlein Purpurası',
          'Hepatoblastoma' => 'Hepatoblastoma',
          'Herediter Sferositoz' => 'Herediter Sferositoz',
          'HIV+' => 'HIV+',
          'Hidronefroz' => 'Hidronefroz',
          'Hidrosefali' => 'Hidrosefali',
          'Hiper IgM Sendromu' => 'Hiper IgM Sendromu',
          'Hipereozinofili' => 'Hipereozinofili',
          'Hiperlipidemi' => 'Hiperlipidemi',
          'Hipertiroidi' => 'Hipertiroidi',
          'Hipoglisemi' => 'Hipoglisemi',
          'Hipotirodi' => 'Hipotirodi',
          'Hirschsprung Sendromu' => 'Hirschsprung Sendromu',
          'Histiositoz' => 'Histiositoz',
          'HSP Nefrit' => 'HSP Nefrit',
          'HSV Ensefalit' => 'HSV Ensefalit',
          'I.T.P (İmmün Trombositopenik Purpura)' => 'I.T.P (İmmün Trombositopenik Purpura)',
          'IgA Nefropatisi' => 'IgA Nefropatisi',
          'IgA Vasküliti' => 'IgA Vasküliti',
          'İdiyopatik Myelofibrozis' => 'İdiyopatik Myelofibrozis',
          'İktiyozis Lameller' => 'İktiyozis Lameller',
          'İleal Atrezi' => 'İleal Atrezi',
          'İmmatür Teratom' => 'İmmatür Teratom',
          'İmmün Yetmezlik' => 'İmmün Yetmezlik',
          'İnfektif Endokardit' => 'İnfektif Endokardit',
          'İntestinal Lenfanjiektazi' => 'İntestinal Lenfanjiektazi',
          'JIA (Jüvenil İdiyopatik Artrit)' => 'JIA (Jüvenil İdiyopatik Artrit)',
          'JMML (Juvenil Myelomonositik Lösemi)' => 'JMML (Juvenil Myelomonositik Lösemi)',
          'Joubert Sendromu' => 'Joubert Sendromu',
          'Juvenil Sarkom' => 'Juvenil Sarkom',
          'Jüvenil Romatoid Artrit' => 'Jüvenil Romatoid Artrit',
          'Kalp Yetmezliği' => 'Kalp Yetmezliği',
          'Kanama Diyatezi' => 'Kanama Diyatezi',
          'Karaciğer Kitlesi' => 'Karaciğer Kitlesi',
          'Karaciğer Transplantasyonu' => 'Karaciğer Transplantasyonu',
          'Karaciğer Yetmezliği' => 'Karaciğer Yetmezliği',
          'Kas Kanseri' => 'Kas Kanseri',
          'Kawasaki' => 'Kawasaki',
          'Kemik iliğinde iltihap' => 'Kemik iliğinde iltihap',
          'Kemik Kanseri' => 'Kemik Kanseri',
          'Kemik Tümörü' => 'Kemik Tümörü',
          'Kırmızı Hücre Aplazi' => 'Kırmızı Hücre Aplazi',
          'Kist Hidatik' => 'Kist Hidatik',
          'Kistik Fibrozis' => 'Kistik Fibrozis',
          'Klinefertel Sendromu' => 'Klinefertel Sendromu',
          'Kloaka Anemisi' => 'Kloaka Anemisi',
          'Kolesterol-Hiperlipidemi' => 'Kolesterol-Hiperlipidemi',
          'Kombine İmmün Yetmezlik' => 'Kombine İmmün Yetmezlik',
          'Kondrosarkom' => 'Kondrosarkom',
          'Konjenital Nefrotik Sendrom' => 'Konjenital Nefrotik Sendrom',
          'Konjenital Nötropeni' => 'Konjenital Nötropeni',
          'Kostman Sendromu' => 'Kostman Sendromu',
          'Krabbe' => 'Krabbe',
          'Kranial Abse' => 'Kranial Abse',
          'Kronik Akciğer Hastalığı' => 'Kronik Akciğer Hastalığı',
          'Kronik Akciğer İltihabı' => 'Kronik Akciğer İltihabı',
          'Kronik Alerjik Astım' => 'Kronik Alerjik Astım',
          'Kronik B12 Vitamin Eksikliği Anemisi' => 'Kronik B12 Vitamin Eksikliği Anemisi',
          'Kronik Böbrek Yetersizliği' => 'Kronik Böbrek Yetersizliği',
          'Kronik Diare' => 'Kronik Diare',
          'Kronik Gastroenterit' => 'Kronik Gastroenterit',
          'Kronik Glomerülonefrit ve İmmün Yetmezlik' => 'Kronik Glomerülonefrit ve İmmün Yetmezlik',
          'Kronik Granülomatoz Hastalık' => 'Kronik Granülomatoz Hastalık',
          'Kronik İdrar Yolu Enfeksiyonu' => 'Kronik İdrar Yolu Enfeksiyonu',
          'Kronik İnflamatuar Demiyelinizan Polinöropati' => 'Kronik İnflamatuar Demiyelinizan Polinöropati',
          'Kronik İTP' => 'Kronik İTP',
          'Kronik İYE Vezikoüretral Reflü' => 'Kronik İYE Vezikoüretral Reflü',
          'Kronik Kabızlık' => 'Kronik Kabızlık',
          'Kronik Kalp Yetmezliği' => 'Kronik Kalp Yetmezliği',
          'Kronik Pankreatit' => 'Kronik Pankreatit',
          'Kronik Pem' => 'Kronik Pem',
          'Kronik Solunum Yolu Enfeksiyonu' => 'Kronik Solunum Yolu Enfeksiyonu',
          'Kronik Vaskülit' => 'Kronik Vaskülit',
          'Langerhans Hücreli Histiositoz (LCH)' => 'Langerhans Hücreli Histiositoz (LCH)',
          'Lenfoma' => 'Lenfoma',
          'Limbik Ensefalit' => 'Limbik Ensefalit',
          'Lösemi' => 'Lösemi',
          'Lupus' => 'Lupus',
          'Lupus Nefriti' => 'Lupus Nefriti',
          'Majör Talasemi' => 'Majör Talasemi',
          'Malign Melanom' => 'Malign Melanom',
          'Malign Mezenkimal Tümör' => 'Malign Mezenkimal Tümör',
          'Malign Neoplazm' => 'Malign Neoplazm',
          'Mandibula Osteosarkomu' => 'Mandibula Osteosarkomu',
          'Mastositoz' => 'Mastositoz',
          'Medullablastom' => 'Medullablastom',
          'Megakolon' => 'Megakolon',
          'Menenjit' => 'Menenjit',
          'Meningoensefalit' => 'Meningoensefalit',
          'Meningomyelosel' => 'Meningomyelosel',
          'Mental Retardasyon' => 'Mental Retardasyon',
          'Mesane Tümörü' => 'Mesane Tümörü',
          'Mezenter Kanseri' => 'Mezenter Kanseri',
          'Methemoglobinemi' => 'Methemoglobinemi',
          'Metil Malonik Asidemi (MMA)' => 'Metil Malonik Asidemi (MMA)',
          'Migren' => 'Migren',
          'Milroy Sendromu' => 'Milroy Sendromu',
          'Minimal Değişiklik Hastalığı' => 'Minimal Değişiklik Hastalığı',
          'Mitokondriyal Miyopati' => 'Mitokondriyal Miyopati',
          'Mitral Yetersizlik' => 'Mitral Yetersizlik',
          'Miyelit' => 'Miyelit',
          'Miyelodisplatik  Sendrom' => 'Miyelodisplatik  Sendrom',
          'Miyokardit' => 'Miyokardit',
          'Miyopati' => 'Miyopati',
          'Morquio tip A/MPS IV A' => 'Morquio tip A/MPS IV A',
          'MPGN' => 'MPGN',
          'MPGN Tip-2' => 'MPGN Tip-2',
          'MPS tip 2 Hunter sendromu' => 'MPS tip 2 Hunter sendromu',
          'MSUD (Akçaağaç Hastalığı)' => 'MSUD (Akçaağaç Hastalığı)',
          'Mukopolisakkaridoz' => 'Mukopolisakkaridoz',
          'Multikistik Displastik Böbrek' => 'Multikistik Displastik Böbrek',
          'Multiple Skleroz (MS)' => 'Multiple Skleroz (MS)',
          'Muskuler Distrofi' => 'Muskuler Distrofi',
          'Myastenia Gravis' => 'Myastenia Gravis',
          'Nazofarenks Kanseri' => 'Nazofarenks Kanseri',
          'Nefrit' => 'Nefrit',
          'Nefroblastom' => 'Nefroblastom',
          'Nefrotik Sendrom' => 'Nefrotik Sendrom',
          'Nefrotik Sendrom - Nakil' => 'Nefrotik Sendrom - Nakil',
          'Nefrotik Sendrom - JRA' => 'Nefrotik Sendrom - JRA',
          'Nefrotik Sendrom (FSGS)' => 'Nefrotik Sendrom (FSGS)',
          'Non İmmun Hemolitik Anemi' => 'Non İmmun Hemolitik Anemi',
          'Nöroblastom' => 'Nöroblastom',
          'Nörofibromatozis' => 'Nörofibromatozis',
          'Nörojenik Mesane' => 'Nörojenik Mesane',
          'Nörojenik Mesane ve Kronik Böbrek Yetmezliği' => 'Nörojenik Mesane ve Kronik Böbrek Yetmezliği',
          'Nörometabolik Hastalık' => 'Nörometabolik Hastalık',
          'Nöronal Displazi' => 'Nöronal Displazi',
          'Nöronal İntestinal Displazi' => 'Nöronal İntestinal Displazi',
          'Nöronal Kanalın Osseöz Stenozu' => 'Nöronal Kanalın Osseöz Stenozu',
          'Nutcracker Sendromu' => 'Nutcracker Sendromu',
          'Nutracer ve Wilkie sendromu' => 'Nutracer ve Wilkie sendromu',
          'Okulomotör Sinir Felci' => 'Okulomotör Sinir Felci',
          'Omurgada Damar Yumağı' => 'Omurgada Damar Yumağı',
          'Omurilik Felci' => 'Omurilik Felci',
          'Omurilik Tümörü' => 'Omurilik Tümörü',
          'Optik Gliom' => 'Optik Gliom',
          'Orak Hücreli Anemi' => 'Orak Hücreli Anemi',
          'Orbital Rabdomiyosarkom' => 'Orbital Rabdomiyosarkom',
          'Orbital Selülit' => 'Orbital Selülit',
          'Osteoblastom' => 'Osteoblastom',
          'Osteogenezis İmperfekta' => 'Osteogenezis İmperfekta',
          'Osteomiyelit' => 'Osteomiyelit',
          'Osteoporoz' => 'Osteoporoz',
          'Osteosarkom' => 'Osteosarkom',
          'Otizm' => 'Otizm',
          'Otoimmün Hemolitik Anemi' => 'Otoimmün Hemolitik Anemi',
          'Otoimmün Lenfoproliferatif Sendrom' => 'Otoimmün Lenfoproliferatif Sendrom',
          'Otomimmun Poliglanduler Yetmezlik' => 'Otomimmun Poliglanduler Yetmezlik',
          'Over Tümörü' => 'Over Tümörü',
          'Özefagus Atrezisi' => 'Özefagus Atrezisi',
          'Özefagus Varisi' => 'Özefagus Varisi',
          'Pankreas İltihabı' => 'Pankreas İltihabı',
          'Pankreatit' => 'Pankreatit',
          'Parameningeal Rabdomiyosarkom' => 'Parameningeal Rabdomiyosarkom',
          'Parapleji' => 'Parapleji',
          'Patent ductus arteriozus (PDA)' => 'Patent ductus arteriozus (PDA)',
          'Perikardit' => 'Perikardit',
          'Periyodik Kusma Sendromu' => 'Periyodik Kusma Sendromu',
          'PFAPA (Periyodik Ateş Sendromu)' => 'PFAPA (Periyodik Ateş Sendromu)',
          'Pıhtılaşma Bozukluğu' => 'Pıhtılaşma Bozukluğu',
          'Pineal Bez Malign Neoplazmı' => 'Pineal Bez Malign Neoplazmı',
          'Pineoblastoma' => 'Pineoblastoma',
          'Pleomorfik Sarkom' => 'Pleomorfik Sarkom',
          'PNET (Primitif Nöroektodermal Tümörler)' => 'PNET (Primitif Nöroektodermal Tümörler)',
          'Poliarteritis Nodoza' => 'Poliarteritis Nodoza',
          'Polikistik Böbrek Hastalığı' => 'Polikistik Böbrek Hastalığı',
          'Pons Gliomu' => 'Pons Gliomu',
          'Portal Hipertansiyon' => 'Portal Hipertansiyon',
          'Portal Ven Trombozu' => 'Portal Ven Trombozu',
          'Prader Willi Sendromu' => 'Prader Willi Sendromu',
          'Primer Hiperoksaluri' => 'Primer Hiperoksaluri',
          'Protein C Eksikliği' => 'Protein C Eksikliği',
          'Psödotümör Serebri' => 'Psödotümör Serebri',
          'Psöriyazis (Sedef Hastalığı)' => 'Psöriyazis (Sedef Hastalığı)',
          'Pulmoner Atrezi' => 'Pulmoner Atrezi',
          'Pulmoner AV fistül' => 'Pulmoner AV fistül',
          'Pulmoner Darlık' => 'Pulmoner Darlık',
          'Pulmoner Hemosideroz' => 'Pulmoner Hemosideroz',
          'Rabdoid Tümör' => 'Rabdoid Tümör',
          'Rabdomyosarkom' => 'Rabdomyosarkom',
          'Renal Transplantasyon' => 'Renal Transplantasyon',
          'Retinoblastoma' => 'Retinoblastoma',
          'RNFC' => 'RNFC',
          'Romatoid Artrit' => 'Romatoid Artrit',
          'Safra Kesesinde Taş' => 'Safra Kesesinde Taş',
          'Safra Yolları Lazerasyonu' => 'Safra Yolları Lazerasyonu',
          'Sağ Beyin Hemisferinde Gelişim Geriliği' => 'Sağ Beyin Hemisferinde Gelişim Geriliği',
          'SCA' => 'SCA',
          'Seckel Sendromu' => 'Seckel Sendromu',
          'Sedef Hastalığı' => 'Sedef Hastalığı',
          'Septik Artrit' => 'Septik Artrit',
          'Serebellar Ataksi' => 'Serebellar Ataksi',
          'Serebral Palsi' => 'Serebral Palsi',
          'Serebral Vaskülit' => 'Serebral Vaskülit',
          'Sinoviyal Sarkom' => 'Sinoviyal Sarkom',
          'Siroz' => 'Siroz',
          'Sistemik JIA' => 'Sistemik JIA',
          'Sistemik JRA +' => 'Sistemik JRA +',
          'Sistemik Lupus Eritematozus (SLE)' => 'Sistemik Lupus Eritematozus (SLE)',
          'Sistinozis' => 'Sistinozis',
          'Sitrülinemi' => 'Sitrülinemi',
          'Skolyoz' => 'Skolyoz',
          'Spinal Musküler Atrofi (SMA)' => 'Spinal Musküler Atrofi (SMA)',
          'Spina Bifida' => 'Spina Bifida',
          'SSPE (Subakut Sklerozan Panensefalit)' => 'SSPE (Subakut Sklerozan Panensefalit)',
          'Şarbon Hastalığı' => 'Şarbon Hastalığı',
          'Takayasu Arteriti' => 'Takayasu Arteriti',
          'Talasemi' => 'Talasemi',
          'Talasemi İntermedia' => 'Talasemi İntermedia',
          'Talasemi Major' => 'Talasemi Major',
          'T-ALL' => 'T-ALL',
          'Tekrarlayan Bronşit' => 'Tekrarlayan Bronşit',
          'Testis Tümörü' => 'Testis Tümörü',
          'Timus Karsinomu' => 'Timus Karsinomu',
          'Transvers Miyelit' => 'Transvers Miyelit',
          'Triküspit atrezisi' => 'Triküspit atrezisi',
          'TTP (Trombotik Trombositik Purpura)' => 'TTP (Trombotik Trombositik Purpura)',
          'Turner Sendromu' => 'Turner Sendromu',
          'Uzun Zincirli Yağ Asidi Enzim Eksiliği' => 'Uzun Zincirli Yağ Asidi Enzim Eksiliği',
          'Ülseratif Kolit' => 'Ülseratif Kolit',
          'Vaskülit' => 'Vaskülit',
          'Ventriküler Septum Defekti' => 'Ventriküler Septum Defekti',
          'Von Willebrand Faktör Eksikliği' => 'Von Willebrand Faktör Eksikliği',
          'VUR (Veziko Üretral Reflü)' => 'VUR (Veziko Üretral Reflü)',
          'VUR\'a Bağlı Hidronefroz' => 'VUR\'a Bağlı Hidronefroz',
          'West Sendromu' => 'West Sendromu',
          'Wilms Tümörü' => 'Wilms Tümörü',
          'Wilson Hastalığı' => 'Wilson Hastalığı',
          'Wiskott Aldrich Sendromu' => 'Wiskott Aldrich Sendromu',
          'X-LPS (X-Linked Lenfoproliferatif Sendrom)' => 'X-LPS (X-Linked Lenfoproliferatif Sendrom)',
        ];
        return view('admin.child.create', compact(['faculties','authUser', 'users', 'diagnosis']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateChildRequest $request)
    {
        $similarChildren = Child::
            where('first_name', 'like', '%' . $request->first_name . '%')
            ->where('last_name', 'like', '%' . $request->last_name . '%')->with('users', 'faculty')->get();
        if(count($similarChildren) != 0 && $request->accepted == '0'){
            $message = "";
            foreach($similarChildren as $similarChild){
                $message = $message . "<p>";
                $message = $message . "<strong>Çocuk: </strong>" . $similarChild->full_name . "<br>";
                $message = $message . "<strong>Fakülte: </strong>" . $similarChild->faculty->full_name . " Tıp Fakültesi<br>";
                $message = $message . "<strong>Sorumlular: </strong>";
                foreach($similarChild->users as $childUser){
                    $message = $message . $childUser->full_name . ", ";
                }
                $message = $message . "</p>";
            }
            Session::flash('similarChildren', $message);
            Session::flash('error_message', ' Bu isimde çocuk var.');
            return redirect()->back()->withInput();
        }
        $user = Auth::user();

        if($request->get('faculty_id') == null){ $request['faculty_id'] = $user->faculty_id; }
        $request['gift_state'] = 'Bekleniyor';
        $child = new Child($request->except(['accepted', 'users', 'website_text', 'website_image', 'ratio', 'rotation','x','y','w','h','verification_doc','next','facebook_text','twitter_text','instagram_text']));
        $child->until = $child->meeting_day->copy()->addYear()->format('d.m.Y');
        $child->save();
        $child->users()->attach($request->users);
        $child->slug = str_slug($this->removeTurkish($child->first_name) . "-" . $child->id);

        if($request->hasFile('verification_doc') ){
            $verificationDoc = Image::make($request->file('verification_doc'))
                ->resize(1500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('resources/admin/uploads/verification_docs/' . $child->id . '_ver.jpg', 80);
            $child->verification_doc =  $child->id . '_ver.jpg';
        }
        $child->save();

        $post = new Post();
        $post->child_id = $child->id;
        $post->text = $request->website_text;
        $post->type = "Tanışma";
        $post->save();

        $postImage = new PostImage();
        $postImage->post_id = $post->id;
        $postImage->name = $child->id . '_1.jpg';
        $postImage->ratio = $request->ratio;
        $postImage->save();


        //TODO: Uncomment when all child moved
//        $social = new Social();
//        $social->created_by = $user->id;
//        $social->child_id = $child->id;
//        $social->facebook_text = $request->facebook_text;
//        if($request->twitter_text == '' || $request->twitter_text == null){
//            $social->twitter_text = $request->facebook_text;
//        }
//        else{
//            $social->twitter_text = $request->twitter_text;
//        }
//
//        if($request->instagram_text == '' || $request->instagram_text == null){
//            $social->instagram_text = $request->facebook_text;
//        }
//        else{
//            $social->instagram_text = $request->instagram_text;
//        }

        $faculty = Faculty::find($request->get('faculty_id'));
//        $social->link = route('public.child', [$faculty->slug, $child->slug]);
//        $social->save();

//        $socialImage = new SocialImage();
//        $socialImage->social_id = $social->id;
//        $socialImage->name = $child->id . '_1.jpg';
//        $socialImage->save();

        ini_set('max_execution_time', 300);
        ini_set("memory_limit", "-1");

        $imageSize = 800;
        $textYLoc = 860;
        $socialSize = 1280;

        if ($request->ratio == '2/3'){
            $imageSize = 800;
            $textYLoc = 1350;
            $socialSize = 960;
        }

        $imgPost = Image::make($request->file('website_image'))
            ->rotate(-$request->rotation)
            ->crop($request->w, $request->h, $request->x, $request->y)
            ->resize($imageSize, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save('resources/admin/uploads/child_photos/' . $postImage->name, 90);

        //TODO: Uncomment when all child moved
//        $imgSocial = Image::make($request->file('website_image'))
//            ->rotate(-$request->rotation)
//            ->crop($request->w, $request->h, $request->x, $request->y)
//            ->resize($socialSize, null, function ($constraint) {
//                $constraint->aspectRatio();
//            })
//            ->text('Çukurova Tıp - Adana', 51, $textYLoc + 1, function($font) {
//                $font->file(public_path('resources/admin/fonts/amatic-bold.ttf'));
//                $font->size(64);
//                $font->color('#313131');
//                $font->valign('top');
//            })
//            ->text('Çukurova Tıp - Adana', 50, $textYLoc, function($font) {
//                $font->file(public_path('resources/admin/fonts/amatic-bold.ttf'));
//                $font->size(64);
//                $font->color('#ffffff');
//                $font->valign('top');
//            });

        ini_restore("memory_limit");
        ini_restore("max_execution_time");
        Session::flash('success_message', $child->first_name . ' başarıyla sisteme eklendi.');

        $process = new Process;
        $process->child_id = $child->id;
        $process->created_by = $user->id;
        $process->desc = "Çocuk sisteme girildi.";
        $process->save();

        $feed = new Feed;
        $feed->desc = $child->full_name . " ile tanışıldı.";
        $feed->icon = 1;
        $feed->faculty_id = $child->faculty_id;
        $feed->title = "All";
        $feed->save();

        if($request->next == 1){
            return redirect()->route('admin.child.create');
        }
        return redirect()->route('admin.user.children', $user->id );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $child = Child::with('faculty','users','processes')->find($id);
        $meeting_post = Post::meetingPost($child->id)->with('images')->first();
        $gift_post = Post::giftPost($child->id)->with('images')->first();
        return view('admin.child.show', compact(['child','meeting_post', 'gift_post']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authUser = Auth::user();
        $child = Child::with('users')->find($id);
        $users = User::select('id', DB::raw('CONCAT(first_name, " ", last_name) AS fullname2'), 'faculty_id')->where('faculty_id',$child->faculty_id)->orderby('first_name')->lists('fullname2', 'id');
        $faculties = Faculty::all('full_name','id');
        $faculty = Faculty::findOrFail($child->faculty_id);
        $meeting_post = Post::meetingPost($child->id)->with('images')->first();
        $gift_post = Post::giftPost($child->id)->with('images')->first();
        $selectedUser = $child->users->lists('id')->toArray();
        return view('admin.child.edit', compact(['authUser','users','faculties', 'child','faculty','meeting_post', 'gift_post','selectedUser']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $child = Child::find($id);
//        Session::flash('success_message', $child->first_name . ' başarıyla sisteme eklendi.');
//        return redirect()->back()->withInput();
        $child->update($request->except(['users', 'website_text', 'website_image','delivered_text','delivered_image', 'ratio1', 'rotation1','x1','y1','w1','h1', 'ratio2', 'rotation2','x2','y2','w2','h2','verification_doc']));
        $child->users()->sync($request->get('users'));

        $faculty = Faculty::find($child->faculty_id);

        $meeting_post = Post::meetingPost($child->id)->first();
        if($meeting_post == null){
            $meeting_post = new Post();
            $meeting_post->child_id = $child->id;
            $meeting_post->type = "Tanışma";
        }
        $meeting_post->text = $request->website_text;
        $meeting_post->save();

        if($request->hasFile('website_image')){

            $imageSize = 800;
            if ($request->ratio1 == '2/3'){
                $imageSize = 400;
            }

            if( count($meeting_post->images) == 0){
                $meetingPostImage = new PostImage();
                $meetingPostImage->post_id = $meeting_post->id;
                $meetingPostImage->name = $child->id . '_1.jpg';
                $meetingPostImage->ratio = $request->ratio1;
                $meetingPostImage->save();
            }else{
                $meetingPostImage = $meeting_post->images()->first();
                $meetingPostImage->ratio = $request->ratio1;
                $meetingPostImage->save();
            }

            ini_set("memory_limit","-1");

            $imgPost = Image::make($request->file('website_image'))
                ->rotate(-$request->rotation1)
                ->crop($request->w1, $request->h1, $request->x1, $request->y1)
                ->resize($imageSize, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('resources/admin/uploads/child_photos/' . $meetingPostImage->name, 80);

            ini_restore("memory_limit");

        }
        $meeting_post->save();

        $gift_post = Post::giftPost($child->id)->first();
        if($gift_post == null && ($request->delivered_text != null && $request->delivered_text != '')){
            $gift_post = new Post;
            $gift_post->child_id = $child->id;
            $gift_post->type = "Hediye";
            $gift_post->text = $request->get('delivered_text');
            $gift_post->save();
        }
        else if($request->delivered_text != null && $request->delivered_text != ''){
            $gift_post->text = $request->get('delivered_text');
            $gift_post->save();
        }


        if($request->hasFile('delivered_image')){
            $child->gift_state = 'Teslim Edildi';
            if($gift_post == null){
                $gift_post = new Post;
                $gift_post->child_id = $child->id;
                $gift_post->type = "Hediye";
                $gift_post->text = '';
                $gift_post->save();
            }

            if( count($gift_post->images) == 0){
                $giftPostImage = new PostImage();
                $giftPostImage->post_id = $gift_post->id;
                $giftPostImage->name = $child->id . '_2.jpg';
                $giftPostImage->ratio = $request->ratio2;
                $giftPostImage->save();
            }else{
                $giftPostImage = $gift_post->images()->first();
                $giftPostImage->ratio = $request->ratio2;
                $giftPostImage->save();
            }


            ini_set("memory_limit","-1");
            $imgPost = Image::make($request->file('delivered_image'))
                ->rotate(-$request->rotation2)
                ->crop($request->w2, $request->h2, $request->x2, $request->y2)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('resources/admin/uploads/child_photos/' . $giftPostImage->name, 80);
            ini_restore("memory_limit");

        }

        if($request->hasFile('verification_doc') ){
            $verificationDoc = Image::make($request->file('verification_doc'))
                ->resize(1500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('resources/admin/uploads/verification_docs/' . $child->id . '_ver.jpg', 80);
            $child->verification_doc =  $child->id . '_ver.jpg';
        }
        $child->save();
        return redirect()->route('admin.child.show', $child->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $child = Child::find($id);
        $posts = $child->posts;
        foreach( $posts as $post){
            foreach( $post->images as $image){
                File::delete('resources/admin/uploads/child_photos/' . $image->name);
                $image->delete();
            }
            $post->delete();
        }
        File::delete('resources/admin/uploads/verification_docs/' . $child->verification_doc);
        Process::where('child_id', $id)->delete();
        $desc = Auth::user()->full_name . ", " . $child->full_name . " isimli çocuğunuzu sildi.";
        $feed = new Feed([
            'desc' => $desc,
            'icon' => '4',
            'faculty_id' => $child->faculty_id,
            'title' => 'All'
        ]);
        $feed->save();

        $child->delete();
        //TODO: Add chats, socials
        return http_response_code(200);
    }

    public function volunteered(Request $request, $id){
        $child = Child::find($id);
        if( $child == null)
            abort(404);

        $volunteer = Volunteer::find($request->volunteer_id);

        $child->volunteer_id = $request->volunteer_id;
        $child->gift_state = 'Yolda';
        if($child->save()){
            $process = new Process;
            $process->created_by = Auth::user()->id;
            $process->child_id = $child->id;
            $process->desc = $volunteer->first_name . ' ' . $volunteer->last_name .' gönüllü olarak belirlendi.';
            $process->save();
        }


        return json_encode( ['message' => $child->first_name . " gönüllüsü " . $volunteer->first_name . " olarak güncellendi."]);
    }

    public function chats(Request $request, $id){
        $child = Child::find($id);
        $chats = $child->chats()->with('volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift')->orderBy('id','desc')->get();
        return $chats;
    }

    public function chat($id, $chatID){
        $chat = Chat::where('id', $chatID)->with('messages', 'volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift', 'messages.sender', 'messages.answerer')->first();
        return $chat;
    }

    public function chatsOpens(Request $request, $id){
        $child = Child::find($id);
        $chats = $child->openChats()->with('volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift')->orderBy('id','desc')->get();
        return $chats;
    }

    public function createProcess(Request $request)
    {
        $user = Auth::user();
        $process = new Process;
        $process->created_by = $user->id;
        $process->child_id = $request->child_id;
        $process->desc = $request->desc;
        $process->save();
        if($request->type == 1){
            $child = Child::find($process->child_id);
            $child->gift_state = 'Bize Ulaştı';
            $child->save();

            $users = $child->users;
            foreach ($users as $value) {
                \Mail::send('email.admin.giftarrival', ['user' => $value, 'child' => $child], function ($message) use ($value, $child) {
                    $message
                        ->to($value->email)
                        ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
                        ->subject('Çocuğunuzun hediyesi bize ulaştı.');
                });
            }


            $feed = new Feed;
            $feed->desc = $child->full_name . " hediyesi geldi.";
            $feed->icon = 3;
            $feed->faculty_id = $child->faculty_id;
            $feed->title = "All";
            $feed->save();

        }
        else if($request->type == 2){
            $child = Child::find($process->child_id);
            $child->gift_state = 'Yolda';
            $child->save();

            $feed = new Feed;
            $feed->desc = $child->full_name . " için gönüllü bulundu.";
            $feed->icon = 2;
            $feed->faculty_id = $child->faculty_id;
            $feed->title = "All";
            $feed->save();

        }
        else if($request->type == 3){
            $child = Child::find($process->child_id);
            $child->gift_state = 'Teslim Edildi';
            $child->save();

            $feed = new Feed;
            $feed->desc = $child->full_name . " hediyesi teslim edildi.";
            $feed->icon = 2;
            $feed->faculty_id = $child->faculty_id;
            $feed->title = "All";
            $feed->save();

        }
        else if($request->type == 4){
            $child = Child::find($process->child_id);
            $child->gift_state = 'Bekleniyor';
            $child->save();

            $feed = new Feed;
            $feed->desc = $child->full_name . ' hediye durumu "Bekleniyor" olarak güncellendi.';
            $feed->icon = 2;
            $feed->faculty_id = $child->faculty_id;
            $feed->title = "All";
            $feed->save();

        }


        return Process::whereId($process->id)->with('creator')->first();
    }


    //HELPERS
    private  function removeTurkish($string){
        $charsArray = [
            'c'    => ['ç', 'Ç'],
            'g'    => ['ğ', 'Ğ'],
            'i'    => ['I', 'İ', 'ı'],
            'o'    => ['Ö','ö'],
            's'    => ['Ş', 'ş'],
            'u'    => ['ü', 'Ü'],
        ];
        foreach ($charsArray as $key => $val) {
            $string = str_replace($val, $key, $string);
        }
        return $string;
    }
}
