import * as React from 'react';
import { TouchableOpacity, BackHandler, FlatList, View, ScrollView, Text, Alert, } from 'react-native';
import { Container, Header, Content, Form, Item, Picker, Drawer, Spinner } from 'native-base';
import styles from '../estilo/style'
import api from '../services/api'
import AsyncStorage from '@react-native-community/async-storage';
import Sidebar from '../components/sidebar'
import Icon from 'react-native-vector-icons/MaterialIcons'
import Icones from 'react-native-vector-icons/Ionicons'




class Checklist extends React.PureComponent {
    constructor(props) {
        super(props);
        this.state = {
            carregando: 0,
            infoChecklist: 0,
            selectedItem: '',
        }
        this.carrega_infos()
        // this.verificaChecklist()
    }

    closeDrawer = () => {
        this.drawer._root.close()
      }
      openDrawer = () => {
        this.drawer._root.open()
      }

    carrega_infos = async () => {
        const dadosMot = await AsyncStorage.getItem('dadosMot')

        var jResponse = JSON.parse(dadosMot)

        var matricula = jResponse.matricula
        var nome = jResponse.nome
        var cnh = jResponse.cnh

        const infoCarro = await AsyncStorage.getItem('infoCarro')

        var jResponse = JSON.parse(infoCarro)

        var placa = jResponse.placa
        var modelo = jResponse.modelo
        var contrato = jResponse.contrato

        // Alert.alert("Teste", matricula)

        this.setState({
            matricula: matricula,
            nome: nome,
            cnh: cnh,
            placa: placa,
            modelo: modelo,
            contrato: contrato,
        })

        this.verificaChecklist()

    }

    verificaChecklist = async () => {
        this.timer = setTimeout(() => {
            this.buscaChecklist();
        }, 1500)
    }

    atualizar = async () => {
        this.setState({
            infoChecklist: 0,
            carregando: 0
        })

        this.verificaChecklist()
    }

    buscaChecklist = async () => {
        // Alert.alert("teste")
        try {
            // const response = await api.get('/buscaChecklist/')
            const response = await api.post('/buscaChecklist/', {
                "matricula": this.state.matricula,
                "placa": this.state.placa
            })

            var jResponse = JSON.stringify(response.data)

            // console.log(jResponse)

            // Alert.alert("Teste", jResponse)

            if (jResponse == '"Não existem checklists para o veículo informado!"') {
                this.setState({
                    infoChecklist: 0,
                    carregando: 1
                })
            } else {
                const checklist_json = JSON.stringify(response.data.checklist[0])

                // Alert.alert('Teste', "| " + checklist_json + " |")

                const checklist_parse = JSON.parse(checklist_json)

                let nomeMot = response.data.nome
                let placaVeic = response.data.placaVeic
                let polo = checklist_parse.Polo
                { (!polo) ? polo = "Não informado" : polo }
                let movimentacao = checklist_parse.Movimentacao
                { (!movimentacao) ? movimentacao = "Não informado" : movimentacao }
                let turno = checklist_parse.Turno
                { (!turno) ? turno = "Não informado" : turno }
                let jornada = checklist_parse.Jornada
                { (!jornada) ? jornada = "Não informado" : jornada }
                let substituicao = checklist_parse.Substituicao
                { (!substituicao) ? substituicao = "Não" : substituicao }
                let nomeSubstituido = checklist_parse.NomeSubstituido
                { (!nomeSubstituido) ? nomeSubstituido = "-" : nomeSubstituido }
                let justificativa = checklist_parse.Justificativa
                { (!justificativa) ? justificativa = "Não" : justificativa }
                let dataPlantao = checklist_parse.DataPlantao
                { (!dataPlantao) ? dataPlantao = "-" : dataPlantao }
                let carroReserva = checklist_parse.CarroReserva
                { (carroReserva == true) ? carroReserva = "Sim" : carroReserva = "Não" }
                let kilometragem = checklist_parse.Kilometragem
                { (!kilometragem) ? kilometragem = "Não informado" : kilometragem }
                let lataria = checklist_parse.Lataria
                { (lataria == true) ? lataria = "Ok" : lataria = "Não" }
                let limpezaExt = checklist_parse.LimpezaExt
                { (limpezaExt == true) ? limpezaExt = "Ok" : limpezaExt = "Não" }
                let limpezaInt = checklist_parse.LimpezaInt
                { (limpezaInt == true) ? limpezaInt = "Ok" : limpezaInt = "Não" }
                let nvCombustivel = checklist_parse.NvCombustivel
                { (!nvCombustivel) ? nvCombustivel = "Não informado" : nvCombustivel }
                let diantDir = checklist_parse.Pneus[0].DiantDir
                { (!diantDir) ? diantDir = "Não informado" : diantDir }
                let marcaDiantDir = checklist_parse.Pneus[0].MarcaDiantDir
                { (!marcaDiantDir) ? marcaDiantDir = "Não informado" : marcaDiantDir }
                let diantEsq = checklist_parse.Pneus[0].DiantEsq
                { (!diantEsq) ? diantEsq = "Não informado" : diantEsq }
                let marcaDiantEsq = checklist_parse.Pneus[0].MarcaDiantEsq
                { (!marcaDiantEsq) ? marcaDiantEsq = "Não informado" : marcaDiantEsq }
                let trasDir = checklist_parse.Pneus[0].TrasDir
                { (!trasDir) ? trasDir = "Não informado" : trasDir }
                let marcaTrasDir = checklist_parse.Pneus[0].MarcaTrasDir
                { (!marcaTrasDir) ? marcaTrasDir = "Não informado" : marcaTrasDir }
                let trasEsq = checklist_parse.Pneus[0].TrasEsq
                { (!trasEsq) ? trasEsq = "Não informado" : trasEsq }
                let marcaTrasEsq = checklist_parse.Pneus[0].MarcaTrasEsq
                { (!marcaTrasEsq) ? marcaTrasEsq = "Não informado" : marcaTrasEsq }
                let documentos = checklist_parse.ItensRegulares[0].Documentos
                { (documentos == true) ? documentos = "Ok" : documentos = "Não" }
                let cintos = checklist_parse.ItensRegulares[0].Cintos
                { (cintos == true) ? cintos = "Ok" : cintos = "Não" }
                let estepe = checklist_parse.ItensRegulares[0].Estepe
                { (estepe == true) ? estepe = "Ok" : estepe = "Não" }
                let chaveDeRoda = checklist_parse.ItensRegulares[0].ChaveDeRoda
                { (chaveDeRoda == true) ? chaveDeRoda = "Ok" : chaveDeRoda = "Não" }
                let macaco = checklist_parse.ItensRegulares[0].Macaco
                { (macaco == true) ? macaco = "Ok" : macaco = "Não" }
                let triangulo = checklist_parse.ItensRegulares[0].Triangulo
                { (triangulo == true) ? triangulo = "Ok" : triangulo = "Não" }
                let tapetes = checklist_parse.ItensRegulares[0].Tapetes
                { (tapetes == true) ? tapetes = "Ok" : tapetes = "Não" }
                let celular = checklist_parse.ItensRegulares[0].Celular
                { (celular == true) ? celular = "Ok" : celular = "Não" }
                let mesa = checklist_parse.ItensRegulares[0].Mesa
                { (mesa == true) ? mesa = "Ok" : mesa = "Não" }
                let roleteMesa = checklist_parse.ItensRegulares[0].RoleteMesa
                { (roleteMesa == true) ? roleteMesa = "Ok" : roleteMesa = "Não" }
                let luzes = checklist_parse.ItensRegulares[0].Luzes
                { (luzes == true) ? luzes = "Ok" : luzes = "Não" }
                let limousine = checklist_parse.Limousine
                { (!limousine) ? limousine = "Não informado" : limousine }
                let avarias = checklist_parse.Avarias

                if (!avarias) {
                    avarias = "Não"
                    var av_Frontal = 0
                    var av_LateralEsq = 0
                    var av_LateralDir = 0
                    var av_Traseira = 0
                    var av_Teto = 0
                    var av_ParteInf = 0
                } else {
                    avarias = 1
                    var av_Frontal = checklist_parse.Avarias[0].Frontal
                    { (av_Frontal == true) ? av_Frontal = "Sim" : av_Frontal = "Não" }
                    var av_LateralEsq = checklist_parse.Avarias[0].LateralEsq
                    { (av_LateralEsq == true) ? av_LateralEsq = "Sim" : av_LateralEsq = "Não" }
                    var av_LateralDir = checklist_parse.Avarias[0].LateralDir
                    { (av_LateralDir == true) ? av_LateralDir = "Sim" : av_LateralDir = "Não" }
                    var av_Traseira = checklist_parse.Avarias[0].Traseira
                    { (av_Traseira == true) ? av_Traseira = "Sim" : av_Traseira = "Não" }
                    var av_Teto = checklist_parse.Avarias[0].Teto
                    { (av_Teto == true) ? av_Teto = "Sim" : av_Teto = "Não" }
                    var av_ParteInf = checklist_parse.Avarias[0].ParteInf
                    { (av_ParteInf == true) ? av_ParteInf = "Sim" : av_ParteInf = "Não" }
                }

                this.setState({
                    nomeMot: nomeMot,
                    placaVeic: placaVeic,
                    polo: polo,
                    movimentacao: movimentacao,
                    turno: turno,
                    jornada: jornada,
                    substituicao: substituicao,
                    nomeSubstituido: nomeSubstituido,
                    justificativa: justificativa,
                    dataPlantao: dataPlantao,
                    carroReserva: carroReserva,
                    kilometragem: kilometragem,
                    lataria: lataria,
                    limpezaExt: limpezaExt,
                    limpezaInt: limpezaInt,
                    nvCombustivel: nvCombustivel,
                    diantDir: diantDir,
                    marcaDiantDir,
                    diantEsq: diantEsq,
                    marcaDiantEsq: marcaDiantEsq,
                    trasDir: trasDir,
                    marcaTrasDir: marcaTrasDir,
                    trasEsq: trasEsq,
                    marcaTrasEsq: marcaTrasEsq,
                    documentos: documentos,
                    cintos: cintos,
                    estepe: estepe,
                    chaveDeRoda: chaveDeRoda,
                    macaco: macaco,
                    triangulo: triangulo,
                    tapetes: tapetes,
                    celular: celular,
                    mesa: mesa,
                    roleteMesa: roleteMesa,
                    luzes: luzes,
                    limousine: limousine,
                    avarias: avarias,
                    av_Frontal: av_Frontal,
                    av_LateralEsq: av_LateralEsq,
                    av_LateralDir: av_LateralDir,
                    av_Traseira: av_Traseira,
                    av_Teto: av_Teto,
                    av_ParteInf: av_ParteInf,

                    carregando: 1,
                    infoChecklist: 1,
                })
            }

        } catch (error) {
            Alert.alert("Erro de conexão")
        }
    }


    render() {
        return (
            <Drawer
            ref={(ref) => { this.drawer = ref; }}
            content={<Sidebar navigation={this.props.navigation} />}
            onClose={() => this.closeDrawer()}>
                <Container style={styles.backgroundChecklist}>

                    {(this.state.carregando == 0)
                        ? <View style={styles.background}>
                            <Text style={{ fontSize: 26 }}>Carregando</Text>
                            <Spinner color='#ff5c54' />
                        </View>
                        :
                        <View>
                            {(this.state.infoChecklist == 0)
                                ? 
                                <View style={styles.background}>
                                    <View style={{ flex: 1 }}></View>
                                    <View style={{padding: 50}}>
                                        <Text style={{ fontSize: 20 }}>No momento não existem checklists para o veículo informado</Text>
                                    </View>
                                    <TouchableOpacity style={{ padding: 5 }}>
                                        <Icones name={'ios-reload-circle-sharp'} size={80} color={'#ff5c54'} onPress={this.atualizar} />
                                    </TouchableOpacity>


                                    <View style={{ flex: 1 }}></View>
                                    <View style={styles.footer}>
                                        <TouchableOpacity style={{ padding: 5 }}>
                                            <Icon name={'menu'} size={40} color={'white'} onPress={this.openDrawer} />
                                        </TouchableOpacity>
                                    </View>
                                </View>
                                :
                                <View>
                                    <View style={styles.tituloChecklist}>
                                        <Text note>Nome do motorista: </Text>
                                        <Text style={styles.textChecklist}>{this.state.nomeMot}</Text>
                                    </View>
                                    <View style={styles.tituloChecklist}>
                                        <Text note>Placa do veículo: </Text>
                                        <Text style={styles.textChecklist}>{this.state.placaVeic}</Text>
                                        <View style={{ backgroundColor: 'black', height: 1.5, width: '100%', opacity: 1 }} />

                                    </View>


                                    <ScrollView>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Polo: {this.state.polo}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Movimentação: {this.state.movimentacao}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Turno: {this.state.turno}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Jornada: {this.state.jornada}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Substituição: {this.state.substituicao}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Nome Substituído: {this.state.nomeSubstituido}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Justificativa: {this.state.justificativa}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Data do plantão: {this.state.dataPlantao}</Text>
                                            <Text style={styles.textChecklist}></Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Carro Reserva: {this.state.carroReserva}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Kilometragem: {this.state.kilometragem} km</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Lataria: {this.state.lataria}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Limpeza Externa: {this.state.limpezaExt}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Limpeza Interna: {this.state.limpezaInt}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Nível de combustível: {this.state.nvCombustivel}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Pneu dianteiro (direito): {this.state.diantDir}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Marca pneu dianteiro (direito): {this.state.marcaDiantDir}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Pneu dianteiro (esquerdo): {this.state.diantEsq}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Marca pneu dianteiro (esquerdo): {this.state.marcaDiantEsq}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Pneu traseiro (direito): {this.state.trasDir}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Marca pneu traseiro (direito): {this.state.marcaTrasDir}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Pneu traseiro (esquerdo): {this.state.trasEsq}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Marca pneu traseiro (esquerdo): {this.state.marcaTrasEsq}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Documentos: {this.state.documentos}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Cintos: {this.state.cintos}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Estepe: {this.state.estepe}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Chave de roda: {this.state.chaveDeRoda}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Macaco: {this.state.macaco}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Triângulo: {this.state.triangulo}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Tapetes: {this.state.tapetes}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Celular: {this.state.celular}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Mesa: {this.state.mesa}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Rolete mesa: {this.state.roleteMesa}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Luzes: {this.state.luzes}</Text>
                                        </View>
                                        <View style={styles.rowChecklist}>
                                            <Text style={styles.textChecklist}>Limousine: {this.state.limousine}</Text>
                                        </View>
                                        {(this.state.avarias == "Não")
                                            ?
                                            <ScrollView style={styles.rowChecklist}>
                                                <Text style={styles.textChecklist}>Avarias: {this.state.avarias}</Text>
                                            </ScrollView>
                                            :
                                            <View>
                                                <View style={styles.rowChecklist}>
                                                    <Text style={styles.textChecklist}>Avarias frontais: {this.state.av_Frontal}</Text>
                                                </View>
                                                <View style={styles.rowChecklist}>
                                                    <Text style={styles.textChecklist}>Avarias lateral esquerda: {this.state.av_LateralEsq}</Text>
                                                </View>
                                                <View style={styles.rowChecklist}>
                                                    <Text style={styles.textChecklist}>Avarias lateral direita: {this.state.av_LateralDir}</Text>
                                                </View>
                                                <View style={styles.rowChecklist}>
                                                    <Text style={styles.textChecklist}>Avarias traseira: {this.state.av_Traseira}</Text>
                                                </View>
                                                <View style={styles.rowChecklist}>
                                                    <Text style={styles.textChecklist}>Avarias teto: {this.state.av_Teto}</Text>
                                                </View>
                                                <View style={styles.rowChecklist}>
                                                    <Text style={styles.textChecklist}>Avarias parte inferior: {this.state.av_ParteInf}</Text>
                                                </View>

                                            </View>
                                        }
                                    </ScrollView>
                                    <View style={styles.footer}>
                                        <TouchableOpacity style={{ padding: 5 }}>
                                            <Icon name={'menu'} size={40} color={'white'} onPress={this.openDrawer} />
                                        </TouchableOpacity>
                                    </View>
                                </View>
                            }

                        </View>

                    }

                    <View style={styles.footer}>
                        <TouchableOpacity style={{ padding: 5 }}>
                            <Icon name={'menu'} size={40} color={'white'} onPress={this.openDrawer} />
                        </TouchableOpacity>
                    </View>
                </Container>
            </Drawer>
        );
    }
}

export default Checklist;
