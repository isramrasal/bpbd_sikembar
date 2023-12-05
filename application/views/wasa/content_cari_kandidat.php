<div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">

            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
				<li>
                    <a href="<?php echo base_url(); ?>index.php/auth/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            
        <div class="wrapper wrapper-content animated fadeInRight">
		
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Pastikan Anda mengisi data dengan benar.
			</div>
			
			<div class="alert alert-info alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Sistem menampilkan status pegawai.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Status Pegawai</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
							<a class="fullscreen-link">
                                <i class="fa fa-expand"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
					
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td>Minimal Kualifikasi Pendidikan:</td>
										<td>
											<select name="min_pendidikan" id="min_pendidikan">
												<option value=''>- Pilih Minimal Kualifikasi Pendidikan -</option>
												<option value='7'>S3</option>
												<option value='6'>S2</option>
												<option value='5'>S1</option>
												<option value='4'>D3</option>
												<option value='3'>SMA sederajat</option>
												<option value='2'>SMP sederajat</option>
												<option value='1'>SD sederajat</option>
											</select>
										</td>
									</tr>
									</br>
									<tr>
										<td>Minimal Kualifikasi Lama Kerja (Bulan):</td>
										<td>
											<select name="min_lama_kerja" id="min_lama_kerja">
												<option value=''>- Minimal Kualifikasi Lama Kerja (Bulan) -</option>
												<option value='0'>0</option>
												<option value='1'>1</option>
												<option value='2'>2</option>
												<option value='3'>3</option>
												<option value='4'>4</option>
												<option value='5'>5</option>
												<option value='6'>6</option>
												<option value='7'>7</option>
												<option value='8'>8</option>
												<option value='9'>9</option>
												<option value='10'>10</option>
												<option value='11'>11</option>
												<option value='12'>12</option>
												<option value='13'>13</option>
												<option value='14'>14</option>
												<option value='15'>15</option>
												<option value='16'>16</option>
												<option value='17'>17</option>
												<option value='18'>18</option>
												<option value='19'>19</option>
												<option value='20'>20</option>
												<option value='21'>21</option>
												<option value='22'>22</option>
												<option value='23'>23</option>
												<option value='24'>24</option>
												<option value='25'>25</option>
												<option value='26'>26</option>
												<option value='27'>27</option>
												<option value='28'>28</option>
												<option value='29'>29</option>
												<option value='30'>30</option>
												<option value='31'>31</option>
												<option value='32'>32</option>
												<option value='33'>33</option>
												<option value='34'>34</option>
												<option value='35'>35</option>
												<option value='36'>36</option>
												<option value='37'>37</option>
												<option value='38'>38</option>
												<option value='39'>39</option>
												<option value='40'>40</option>
												<option value='41'>41</option>
												<option value='42'>42</option>
												<option value='43'>43</option>
												<option value='44'>44</option>
												<option value='45'>45</option>
												<option value='46'>46</option>
												<option value='47'>47</option>
												<option value='48'>48</option>
												<option value='49'>49</option>
												<option value='50'>50</option>
												<option value='51'>51</option>
												<option value='52'>52</option>
												<option value='53'>53</option>
												<option value='54'>54</option>
												<option value='55'>55</option>
												<option value='56'>56</option>
												<option value='57'>57</option>
												<option value='58'>58</option>
												<option value='59'>59</option>
												<option value='60'>60</option>
												<option value='61'>61</option>
												<option value='62'>62</option>
												<option value='63'>63</option>
												<option value='64'>64</option>
												<option value='65'>65</option>
												<option value='66'>66</option>
												<option value='67'>67</option>
												<option value='68'>68</option>
												<option value='69'>69</option>
												<option value='70'>70</option>
												<option value='71'>71</option>
												<option value='72'>72</option>
												<option value='73'>73</option>
												<option value='74'>74</option>
												<option value='75'>75</option>
												<option value='76'>76</option>
												<option value='77'>77</option>
												<option value='78'>78</option>
												<option value='79'>79</option>
												<option value='80'>80</option>
												<option value='81'>81</option>
												<option value='82'>82</option>
												<option value='83'>83</option>
												<option value='84'>84</option>
												<option value='85'>85</option>
												<option value='86'>86</option>
												<option value='87'>87</option>
												<option value='88'>88</option>
												<option value='89'>89</option>
												<option value='90'>90</option>
												<option value='91'>91</option>
												<option value='92'>92</option>
												<option value='93'>93</option>
												<option value='94'>94</option>
												<option value='95'>95</option>
												<option value='96'>96</option>
												<option value='97'>97</option>
												<option value='98'>98</option>
												<option value='99'>99</option>
												<option value='100'>100</option>
												<option value='101'>101</option>
												<option value='102'>102</option>
												<option value='103'>103</option>
												<option value='104'>104</option>
												<option value='105'>105</option>
												<option value='106'>106</option>
												<option value='107'>107</option>
												<option value='108'>108</option>
												<option value='109'>109</option>
												<option value='110'>110</option>
												<option value='111'>111</option>
												<option value='112'>112</option>
												<option value='113'>113</option>
												<option value='114'>114</option>
												<option value='115'>115</option>
												<option value='116'>116</option>
												<option value='117'>117</option>
												<option value='118'>118</option>
												<option value='119'>119</option>
												<option value='120'>120</option>
												<option value='121'>121</option>
												<option value='122'>122</option>
												<option value='123'>123</option>
												<option value='124'>124</option>
												<option value='125'>125</option>
												<option value='126'>126</option>
												<option value='127'>127</option>
												<option value='128'>128</option>
												<option value='129'>129</option>
												<option value='130'>130</option>
												<option value='131'>131</option>
												<option value='132'>132</option>
												<option value='133'>133</option>
												<option value='134'>134</option>
												<option value='135'>135</option>
												<option value='136'>136</option>
												<option value='137'>137</option>
												<option value='138'>138</option>
												<option value='139'>139</option>
												<option value='140'>140</option>
												<option value='141'>141</option>
												<option value='142'>142</option>
												<option value='143'>143</option>
												<option value='144'>144</option>
												<option value='145'>145</option>
												<option value='146'>146</option>
												<option value='147'>147</option>
												<option value='148'>148</option>
												<option value='149'>149</option>
												<option value='150'>150</option>
												<option value='151'>151</option>
												<option value='152'>152</option>
												<option value='153'>153</option>
												<option value='154'>154</option>
												<option value='155'>155</option>
												<option value='156'>156</option>
												<option value='157'>157</option>
												<option value='158'>158</option>
												<option value='159'>159</option>
												<option value='160'>160</option>
												<option value='161'>161</option>
												<option value='162'>162</option>
												<option value='163'>163</option>
												<option value='164'>164</option>
												<option value='165'>165</option>
												<option value='166'>166</option>
												<option value='167'>167</option>
												<option value='168'>168</option>
												<option value='169'>169</option>
												<option value='170'>170</option>
												<option value='171'>171</option>
												<option value='172'>172</option>
												<option value='173'>173</option>
												<option value='174'>174</option>
												<option value='175'>175</option>
												<option value='176'>176</option>
												<option value='177'>177</option>
												<option value='178'>178</option>
												<option value='179'>179</option>
												<option value='180'>180</option>
												<option value='181'>181</option>
												<option value='182'>182</option>
												<option value='183'>183</option>
												<option value='184'>184</option>
												<option value='185'>185</option>
												<option value='186'>186</option>
												<option value='187'>187</option>
												<option value='188'>188</option>
												<option value='189'>189</option>
												<option value='190'>190</option>
												<option value='191'>191</option>
												<option value='192'>192</option>
												<option value='193'>193</option>
												<option value='194'>194</option>
												<option value='195'>195</option>
												<option value='196'>196</option>
												<option value='197'>197</option>
												<option value='198'>198</option>
												<option value='199'>199</option>
												<option value='200'>200</option>
												<option value='201'>201</option>
												<option value='202'>202</option>
												<option value='203'>203</option>
												<option value='204'>204</option>
												<option value='205'>205</option>
												<option value='206'>206</option>
												<option value='207'>207</option>
												<option value='208'>208</option>
												<option value='209'>209</option>
												<option value='210'>210</option>
												<option value='211'>211</option>
												<option value='212'>212</option>
												<option value='213'>213</option>
												<option value='214'>214</option>
												<option value='215'>215</option>
												<option value='216'>216</option>
												<option value='217'>217</option>
												<option value='218'>218</option>
												<option value='219'>219</option>
												<option value='220'>220</option>
												<option value='221'>221</option>
												<option value='222'>222</option>
												<option value='223'>223</option>
												<option value='224'>224</option>
												<option value='225'>225</option>
												<option value='226'>226</option>
												<option value='227'>227</option>
												<option value='228'>228</option>
												<option value='229'>229</option>
												<option value='230'>230</option>
												<option value='231'>231</option>
												<option value='232'>232</option>
												<option value='233'>233</option>
												<option value='234'>234</option>
												<option value='235'>235</option>
												<option value='236'>236</option>
												<option value='237'>237</option>
												<option value='238'>238</option>
												<option value='239'>239</option>
												<option value='240'>240</option>
												<option value='241'>241</option>
												<option value='242'>242</option>
												<option value='243'>243</option>
												<option value='244'>244</option>
												<option value='245'>245</option>
												<option value='246'>246</option>
												<option value='247'>247</option>
												<option value='248'>248</option>
												<option value='249'>249</option>
												<option value='250'>250</option>
												<option value='251'>251</option>
												<option value='252'>252</option>
												<option value='253'>253</option>
												<option value='254'>254</option>
												<option value='255'>255</option>
												<option value='256'>256</option>
												<option value='257'>257</option>
												<option value='258'>258</option>
												<option value='259'>259</option>
												<option value='260'>260</option>
												<option value='261'>261</option>
												<option value='262'>262</option>
												<option value='263'>263</option>
												<option value='264'>264</option>
												<option value='265'>265</option>
												<option value='266'>266</option>
												<option value='267'>267</option>
												<option value='268'>268</option>
												<option value='269'>269</option>
												<option value='270'>270</option>
												<option value='271'>271</option>
												<option value='272'>272</option>
												<option value='273'>273</option>
												<option value='274'>274</option>
												<option value='275'>275</option>
												<option value='276'>276</option>
												<option value='277'>277</option>
												<option value='278'>278</option>
												<option value='279'>279</option>
												<option value='280'>280</option>
												<option value='281'>281</option>
												<option value='282'>282</option>
												<option value='283'>283</option>
												<option value='284'>284</option>
												<option value='285'>285</option>
												<option value='286'>286</option>
												<option value='287'>287</option>
												<option value='288'>288</option>
												<option value='289'>289</option>
												<option value='290'>290</option>
												<option value='291'>291</option>
												<option value='292'>292</option>
												<option value='293'>293</option>
												<option value='294'>294</option>
												<option value='295'>295</option>
												<option value='296'>296</option>
												<option value='297'>297</option>
												<option value='298'>298</option>
												<option value='299'>299</option>
												<option value='300'>300</option>
												<option value='301'>301</option>
												<option value='302'>302</option>
												<option value='303'>303</option>
												<option value='304'>304</option>
												<option value='305'>305</option>
												<option value='306'>306</option>
												<option value='307'>307</option>
												<option value='308'>308</option>
												<option value='309'>309</option>
												<option value='310'>310</option>
												<option value='311'>311</option>
												<option value='312'>312</option>
												<option value='313'>313</option>
												<option value='314'>314</option>
												<option value='315'>315</option>
												<option value='316'>316</option>
												<option value='317'>317</option>
												<option value='318'>318</option>
												<option value='319'>319</option>
												<option value='320'>320</option>
												<option value='321'>321</option>
												<option value='322'>322</option>
												<option value='323'>323</option>
												<option value='324'>324</option>
												<option value='325'>325</option>
												<option value='326'>326</option>
												<option value='327'>327</option>
												<option value='328'>328</option>
												<option value='329'>329</option>
												<option value='330'>330</option>
												<option value='331'>331</option>
												<option value='332'>332</option>
												<option value='333'>333</option>
												<option value='334'>334</option>
												<option value='335'>335</option>
												<option value='336'>336</option>
												<option value='337'>337</option>
												<option value='338'>338</option>
												<option value='339'>339</option>
												<option value='340'>340</option>
												<option value='341'>341</option>
												<option value='342'>342</option>
												<option value='343'>343</option>
												<option value='344'>344</option>
												<option value='345'>345</option>
												<option value='346'>346</option>
												<option value='347'>347</option>
												<option value='348'>348</option>
												<option value='349'>349</option>
												<option value='350'>350</option>
												<option value='351'>351</option>
												<option value='352'>352</option>
												<option value='353'>353</option>
												<option value='354'>354</option>
												<option value='355'>355</option>
												<option value='356'>356</option>
												<option value='357'>357</option>
												<option value='358'>358</option>
												<option value='359'>359</option>
												<option value='360'>360</option>
												<option value='361'>361</option>
												<option value='362'>362</option>
												<option value='363'>363</option>
												<option value='364'>364</option>
												<option value='365'>365</option>
												<option value='366'>366</option>
												<option value='367'>367</option>
												<option value='368'>368</option>
												<option value='369'>369</option>
												<option value='370'>370</option>
												<option value='371'>371</option>
												<option value='372'>372</option>
												<option value='373'>373</option>
												<option value='374'>374</option>
												<option value='375'>375</option>
												<option value='376'>376</option>
												<option value='377'>377</option>
												<option value='378'>378</option>
												<option value='379'>379</option>
												<option value='380'>380</option>
												<option value='381'>381</option>
												<option value='382'>382</option>
												<option value='383'>383</option>
												<option value='384'>384</option>
												<option value='385'>385</option>
												<option value='386'>386</option>
												<option value='387'>387</option>
												<option value='388'>388</option>
												<option value='389'>389</option>
												<option value='390'>390</option>
												<option value='391'>391</option>
												<option value='392'>392</option>
												<option value='393'>393</option>
												<option value='394'>394</option>
												<option value='395'>395</option>
												<option value='396'>396</option>
												<option value='397'>397</option>
												<option value='398'>398</option>
												<option value='399'>399</option>
												<option value='400'>400</option>
												<option value='401'>401</option>
												<option value='402'>402</option>
												<option value='403'>403</option>
												<option value='404'>404</option>
												<option value='405'>405</option>
												<option value='406'>406</option>
												<option value='407'>407</option>
												<option value='408'>408</option>
												<option value='409'>409</option>
												<option value='410'>410</option>
												<option value='411'>411</option>
												<option value='412'>412</option>
												<option value='413'>413</option>
												<option value='414'>414</option>
												<option value='415'>415</option>
												<option value='416'>416</option>
												<option value='417'>417</option>
												<option value='418'>418</option>
												<option value='419'>419</option>
												<option value='420'>420</option>
												<option value='421'>421</option>
												<option value='422'>422</option>
												<option value='423'>423</option>
												<option value='424'>424</option>
												<option value='425'>425</option>
												<option value='426'>426</option>
												<option value='427'>427</option>
												<option value='428'>428</option>
												<option value='429'>429</option>
												<option value='430'>430</option>
												<option value='431'>431</option>
												<option value='432'>432</option>
												<option value='433'>433</option>
												<option value='434'>434</option>
												<option value='435'>435</option>
												<option value='436'>436</option>
												<option value='437'>437</option>
												<option value='438'>438</option>
												<option value='439'>439</option>
												<option value='440'>440</option>
												<option value='441'>441</option>
												<option value='442'>442</option>
												<option value='443'>443</option>
												<option value='444'>444</option>
												<option value='445'>445</option>
												<option value='446'>446</option>
												<option value='447'>447</option>
												<option value='448'>448</option>
												<option value='449'>449</option>
												<option value='450'>450</option>
												<option value='451'>451</option>
												<option value='452'>452</option>
												<option value='453'>453</option>
												<option value='454'>454</option>
												<option value='455'>455</option>
												<option value='456'>456</option>
												<option value='457'>457</option>
												<option value='458'>458</option>
												<option value='459'>459</option>
												<option value='460'>460</option>
												<option value='461'>461</option>
												<option value='462'>462</option>
												<option value='463'>463</option>
												<option value='464'>464</option>
												<option value='465'>465</option>
												<option value='466'>466</option>
												<option value='467'>467</option>
												<option value='468'>468</option>
												<option value='469'>469</option>
												<option value='470'>470</option>
												<option value='471'>471</option>
												<option value='472'>472</option>
												<option value='473'>473</option>
												<option value='474'>474</option>
												<option value='475'>475</option>
												<option value='476'>476</option>
												<option value='477'>477</option>
												<option value='478'>478</option>
												<option value='479'>479</option>
												<option value='480'>480</option>

											</select>
										</td>
									</tr>
									</br>
									<tr>
                                        <td>Minimal Kualifikasi Umur Karyawan (Tahun):</td>
                                        <td>
											<select name="min_umur" id="min_umur">
												<option value=''>- Pilih Minimal Kualifikasi Umur Karyawan (Tahun) -</option>
												<option value='15'>15</option>
												<option value='16'>16</option>
												<option value='17'>17</option>
												<option value='18'>18</option>
												<option value='19'>19</option>
												<option value='20'>20</option>
												<option value='21'>21</option>
												<option value='22'>22</option>
												<option value='23'>23</option>
												<option value='24'>24</option>
												<option value='25'>25</option>
												<option value='26'>26</option>
												<option value='27'>27</option>
												<option value='28'>28</option>
												<option value='29'>29</option>
												<option value='30'>30</option>
												<option value='31'>31</option>
												<option value='32'>32</option>
												<option value='33'>33</option>
												<option value='34'>34</option>
												<option value='35'>35</option>
												<option value='36'>36</option>
												<option value='37'>37</option>
												<option value='38'>38</option>
												<option value='39'>39</option>
												<option value='40'>40</option>
												<option value='41'>41</option>
												<option value='42'>42</option>
												<option value='43'>43</option>
												<option value='44'>44</option>
												<option value='45'>45</option>
												<option value='46'>46</option>
												<option value='47'>47</option>
												<option value='48'>48</option>
												<option value='49'>49</option>
												<option value='50'>50</option>
												<option value='51'>51</option>
												<option value='52'>52</option>
												<option value='53'>53</option>
												<option value='54'>54</option>
												<option value='55'>55</option>
												<option value='56'>56</option>
												<option value='57'>57</option>
												<option value='58'>58</option>
												<option value='59'>59</option>
												<option value='60'>60</option>
												<option value='61'>61</option>
												<option value='62'>62</option>
												<option value='63'>63</option>
												<option value='64'>64</option>
												<option value='65'>65</option>
												<option value='66'>66</option>
												<option value='67'>67</option>
												<option value='68'>68</option>
												<option value='69'>69</option>
												<option value='70'>70</option>
												<option value='71'>71</option>
												<option value='72'>72</option>
												<option value='73'>73</option>
												<option value='74'>74</option>
												<option value='75'>75</option>
												<option value='76'>76</option>
												<option value='77'>77</option>
												<option value='78'>78</option>
												<option value='79'>79</option>
												<option value='80'>80</option>
											</select>
										</td>
                                    </tr>
									<tr>
										<td>Maksimal Kualifikasi Umur Karyawan (Tahun):</td>
										<td>
										<select name="max_umur" id="max_umur">
												<option value=''>- Pilih Maksimal Kualifikasi Umur Karyawan (Tahun) -</option>
												<option value='15'>15</option>
												<option value='16'>16</option>
												<option value='17'>17</option>
												<option value='18'>18</option>
												<option value='19'>19</option>
												<option value='20'>20</option>
												<option value='21'>21</option>
												<option value='22'>22</option>
												<option value='23'>23</option>
												<option value='24'>24</option>
												<option value='25'>25</option>
												<option value='26'>26</option>
												<option value='27'>27</option>
												<option value='28'>28</option>
												<option value='29'>29</option>
												<option value='30'>30</option>
												<option value='31'>31</option>
												<option value='32'>32</option>
												<option value='33'>33</option>
												<option value='34'>34</option>
												<option value='35'>35</option>
												<option value='36'>36</option>
												<option value='37'>37</option>
												<option value='38'>38</option>
												<option value='39'>39</option>
												<option value='40'>40</option>
												<option value='41'>41</option>
												<option value='42'>42</option>
												<option value='43'>43</option>
												<option value='44'>44</option>
												<option value='45'>45</option>
												<option value='46'>46</option>
												<option value='47'>47</option>
												<option value='48'>48</option>
												<option value='49'>49</option>
												<option value='50'>50</option>
												<option value='51'>51</option>
												<option value='52'>52</option>
												<option value='53'>53</option>
												<option value='54'>54</option>
												<option value='55'>55</option>
												<option value='56'>56</option>
												<option value='57'>57</option>
												<option value='58'>58</option>
												<option value='59'>59</option>
												<option value='60'>60</option>
												<option value='61'>61</option>
												<option value='62'>62</option>
												<option value='63'>63</option>
												<option value='64'>64</option>
												<option value='65'>65</option>
												<option value='66'>66</option>
												<option value='67'>67</option>
												<option value='68'>68</option>
												<option value='69'>69</option>
												<option value='70'>70</option>
												<option value='71'>71</option>
												<option value='72'>72</option>
												<option value='73'>73</option>
												<option value='74'>74</option>
												<option value='75'>75</option>
												<option value='76'>76</option>
												<option value='77'>77</option>
												<option value='78'>78</option>
												<option value='79'>79</option>
												<option value='80'>80</option>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="table-responsive">
							<form id="frm-example" action="/wasa/index.php/cari_kandidat/update_data" method="POST">
								</br>
								</br>
								<table class="table table-striped table-bordered table-hover"  id="example">
									
									<thead>
										<tr>
											<th>Pilih Kandidat</th>
											<th>NIP</th>
											<th>Nama Pegawai</th>
											<th>KODE_JENJANG_PENDIDIKAN</th>
											<th>Pendidikan</th>
											<th>Lama Bekerja (Bulan)</br>Sejak Kontrak</br>Sampai Sekarang</th>
											<th>Umur (Tahun)</th>
											<th>Jabatan Saat Ini</th>
											<th>Departemen Saat Ini</th>
										</tr>
									</thead>
									<tbody id="show_data">
								
									</tbody>
						 
								</table>
								<hr>

							<p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p>

							<p><button>Submit</button></p>

							<p><b>Selected rows data:</b></p>
							<pre id="example-console-rows"></pre>

							<p><b>Form data as submitted to the server:</b></p>
							<pre id="example-console-form"></pre>
							</form>
						</div>
						
						
						
						
                    </div>
					
                </div>
            </div>
            </div>
        </div>
		</br>
		
        <div class="footer">
			<div>
				<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br/> Hak cipta dilindungi undang-undang.</p>
			</div> 
        </div>

        </div>
        </div>
		
		
    <!-- Mainly scripts -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/wasa/dataTableBaru/jquery-1.11.0.js.download"></script>
	
    <script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- dataTables -->
	
	<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/wasa/dataTableBaru/dataTables.checkboxes.min.js.download"></script>
	
    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>
	
    <!-- Page-Level Scripts -->
    <script type="text/javascript">
	
	$.fn.dataTable.ext.search.push(
		function( settings, data, dataIndex ) {
			var min_umur = parseInt( $('#min_umur').val(), 10 );
			var max_umur = parseInt( $('#max_umur').val(), 10 );
			var umur = parseFloat( data[6] ) || 0; // use data for the umur column
			
			var min_pendidikan = parseInt( $('#min_pendidikan').val(), 10 );
			var pendidikan = parseFloat( data[3] ) || 0; // use data for the pendidikan column
			
			var min_lama_kerja = parseInt( $('#min_lama_kerja').val(), 10 );
			var lama_kerja = parseFloat( data[5] ) || 0; // use data for the lama_kerja column
	 
			if ( ( isNaN( min_umur ) && isNaN( max_umur ) ) ||
				 ( isNaN( min_umur ) && umur <= max_umur ) ||
				 ( min_umur <= umur   && isNaN( max_umur ) ) ||
				 ( min_umur <= umur   && umur <= max_umur ) )
			if ( ( isNaN( min_pendidikan ) && isNaN( '7' ) ) ||
				 ( isNaN( min_pendidikan ) && pendidikan <= '7' ) ||
				 ( min_pendidikan <= pendidikan   && isNaN( '7' ) ) ||
				 ( min_pendidikan <= pendidikan   && pendidikan <= '7' ) )
			if ( ( isNaN( min_lama_kerja ) && isNaN( '480' ) ) ||
				 ( isNaN( min_lama_kerja ) && lama_kerja <= '480' ) ||
				 ( min_lama_kerja <= lama_kerja   && isNaN( '480' ) ) ||
				 ( min_lama_kerja <= lama_kerja   && lama_kerja <= '480' ) )
			{
				return true;
			}
			return false;
		}
	);
	
	
	$(document).ready(function() {
		
		tampil_data_pegawai();	//pemanggilan fungsi tampil data.
		
		var table = $('#example').DataTable({
			'columnDefs': [
			 {
				'targets': 0,
				'checkboxes': {
				   'selectRow': true
				}
			 },
			 {
				'visible':false,
				'targets':3
			 }
			],
			'responsive': true,
			'dom': '<"html5buttons"B>lTfgitp',
			'select': {
			 'style': 'multi'
			},
			'order': [[1, 'asc']],
			'buttons': [
                    {'extend': 'copy'},
                    {'extend': 'csv'},
                    {'extend': 'excel', 'title': 'Cari Kandidat'},
                    {'extend': 'pdf', 'title': 'Cari Kandidat'}
                ]
		});
			
		// Event listener to the two range filtering inputs to redraw on input
		$('#max_umur').change( function() {
			table.draw();
		} );
		
		$('#min_umur').change( function() {
		table.draw();
		});
		
		$('#min_pendidikan').change( function() {
		table.draw();
		});
		
		$('#min_lama_kerja').change( function() {
			table.draw();
		} );
		
		var data_rows = table.rows().data();
		var data_column = table.column().data();
     
		console.log(data_column);
		console.log(data_rows);
		console.log(data_rows[0]);
		console.log(data_rows[0][1]);
		console.log( 'The table has ' + data_rows.length + ' records' );
		
		// Handle form submission event 
		$('#frm-example').on('submit', function(e){
		  var form = this;
		  
		  var rows_selected = table.column(0).checkboxes.selected();
		  console.log(rows_selected);
		  
		  // Iterate over all selected checkboxes
		  $.each(rows_selected, function(index, rowId){
			  console.log(rowId);
			 // Create a hidden element 
			 $(form).append(
				 $('<input>')
					.attr('type', 'hidden')
					.attr('name', 'id[]')
					.val(rowId)
			 );
		  });

		  // FOR DEMONSTRATION ONLY
		  // The code below is not needed in production
		  
		  // Output form data to a console     
		  $('#example-console-rows').text(rows_selected.join(","));
		  
		  // Output form data to a console     
		  $('#example-console-form').text($(form).serialize());
		   
		  // Remove added elements
		  $('input[name="id\[\]"]', form).remove();
		   
		  // Prevent actual form submission
		  e.preventDefault();
		});

		//fungsi tampil data
		function tampil_data_pegawai(){
			$.ajax({
				type  : 'ajax',
				url   : '<?php echo base_url()?>index.php/cari_kandidat/data_cari_kandidat',
				async : false,
				dataType : 'json',
				success : function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
						
						if(data[i].username != null)
						{
						username = data[i].username;
						}
						else
						{
						username = 'Belum Registrasi';
						}
						
						
						html += '<tr>'+
								'<td>'+data[i].NIP+'</td>'+
								'<td>'+data[i].NIP+'</td>'+
								'<td>'+data[i].NAMA+'</td>'+
								'<td>'+data[i].KODE_JENJANG_PENDIDIKAN+'</td>'+
								'<td>'+data[i].JENJANG_PENDIDIKAN+'</td>'+
								'<td>'+data[i].LAMA_BEKERJA_KONTRAK+'</td>'+
								'<td>'+data[i].UMUR+'</td>'+
								'<td>'+data[i].NAMA_JABATAN+'</td>'+
								'<td>'+data[i].NAMA_DEPARTEMEN+'</td>'+
								'</tr>';
					}
					$('#show_data').html(html);
				}

			});
		}
		
		

	});

	</script>

</body>

</html>