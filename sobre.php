<?php
// ============================================
// SOBRE.PHP - PÁGINA SOBRE NÓS
// ============================================
// Página institucional que conta a história da loja
// Mostra missão, visão, valores e diferenciais

// INCLUI O CABEÇALHO
// Inclui o arquivo de cabeçalho, que contém elementos comuns a todas as páginas.
require_once 'header.php';
?>

<!-- ============================================ -->
<!-- HTML DA PÁGINA -->
<!-- ============================================ -->

<div class="container">

    
    <!-- ======================================== -->
    <!-- BREADCRUMB (NAVEGAÇÃO) -->
    <!-- ======================================== -->
    <div class="breadcrumb">
        <a href="index.php">Início</a>
        <span>→</span>
        <span>Sobre Nós</span>
    </div>


    <!-- ======================================== -->
    <!-- CABEÇALHO DA PÁGINA -->
    <!-- ======================================== -->
    <div class="page-header">
        <h1>Sobre a Tech Store</h1>
        <p>Conheça nossa história e nossos valores</p>
    </div>


    <!-- ======================================== -->
    <!-- SEÇÃO: NOSSA HISTÓRIA -->
    <!-- ======================================== -->
    <div class="card" style="margin-bottom: 32px;">
        <div class="card-content">
            
            <!-- GRID: 2 COLUNAS -->

            <!-- Esquerda: texto / Direita: destaque visual -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center;">
                
                <!-- COLUNA 1: TEXTO -->
                <div>
                    <!-- Emoji grande -->
                    <div style="font-size: 48px; margin-bottom: 16px;">🎮</div>
                    
                    <h2 style="font-size: 32px; margin-bottom: 16px;">Nossa História</h2>
                    
                    <!-- Parágrafo 1 -->
                    <p style="line-height: 1.8; color: var(--text-secondary); margin-bottom: 16px;">
                        Fundada em 2024, a <strong style="color: var(--primary);">Tech Store</strong> nasceu da paixão 
                        por tecnologia e jogos. Começamos como um pequeno projeto e rapidamente nos tornamos 
                        referência em periféricos gamer de alta qualidade.
                    </p>
                    
                    <!-- Parágrafo 2 -->
                    <p style="line-height: 1.8; color: var(--text-secondary);">
                        Hoje, atendemos milhares de clientes em todo o Brasil, oferecendo os melhores produtos 
                        do mercado com preços justos e atendimento excepcional.
                    </p>
                </div>
                
                <!-- COLUNA 2: DESTAQUE VISUAL -->
                <div style="text-align: center;">
                    <!-- Card colorido com gradiente -->
                    <div style="background: linear-gradient(135deg, var(--primary-light), var(--primary)); padding: 48px; border-radius: 16px; color: white;">
                        <!-- Ano em destaque -->
                        <div style="font-size: 64px; font-weight: 700; margin-bottom: 8px;">2024</div>
                        <div style="font-size: 20px; opacity: 0.9;">Ano de Fundação</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ======================================== -->
    <!-- SEÇÃO: MISSÃO, VISÃO E VALORES -->
    <!-- ======================================== -->
    <!-- GRID: 3 CARDS LADO A LADO -->
    <div class="grid grid-3" style="margin-bottom: 32px;">
        
        <!-- CARD 1: MISSÃO -->

        <div class="card">
            <div class="card-content" style="text-align: center;">
                
                <!-- Ícone em círculo colorido -->
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #e3f2fd, #90caf9); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px;">
                    🎯
                </div>
                
                <h3 style="font-size: 22px; margin-bottom: 16px;">Nossa Missão</h3>
                
                <p style="color: var(--text-secondary); line-height: 1.8;">
                    Proporcionar a melhor experiência de compra online, com produtos de qualidade, 
                    entrega rápida e suporte especializado.
                </p>
            </div>
        </div>

        <!-- CARD 2: VISÃO -->

        <div class="card">
            <div class="card-content" style="text-align: center;">
                
                <!-- Ícone roxo -->
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e5f5, #ce93d8); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px;">
                    👁️
                </div>
                
                <h3 style="font-size: 22px; margin-bottom: 16px;">Nossa Visão</h3>
                
                <p style="color: var(--text-secondary); line-height: 1.8;">
                    Ser a loja de periféricos gamer mais confiável e querida do Brasil, 
                    reconhecida pela excelência no atendimento.
                </p>
            </div>
        </div>

        <!-- CARD 3: VALORES -->

        <div class="card">
            <div class="card-content" style="text-align: center;">
                
                <!-- Ícone verde -->
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #e8f5e9, #81c784); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px;">
                    ⭐
                </div>
                
                <h3 style="font-size: 22px; margin-bottom: 16px;">Nossos Valores</h3>
                
                <p style="color: var(--text-secondary); line-height: 1.8;">
                    Qualidade, confiança, inovação e atendimento excepcional. 
                    Cliente satisfeito é nossa maior conquista.
                </p>
            </div>
        </div>
    </div>


    <!-- ======================================== -->
    <!-- SEÇÃO: POR QUE ESCOLHER -->
    <!-- ======================================== -->
    <div class="card" style="margin-bottom: 32px;">
        <div class="card-content">
            
            <h2 style="font-size: 32px; margin-bottom: 32px; text-align: center;">

                Por Que Escolher a Tech Store?
            </h2>
            
            <!-- GRID: 2 COLUNAS DE DIFERENCIAIS -->
            <div class="grid grid-2" style="gap: 24px;">
                
                <!-- DIFERENCIAL 1 -->

                <div style="display: flex; gap: 20px;">
                    <!-- Ícone em quadrado colorido -->
                    <div style="flex-shrink: 0; width: 56px; height: 56px; background: linear-gradient(135deg, var(--primary-light), var(--primary)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        ✓
                    </div>
                    <div>
                        <h3 style="font-size: 20px; margin-bottom: 8px;">Produtos Originais</h3>
                        <p style="color: var(--text-secondary);">
                            Trabalhamos apenas com marcas oficiais e produtos certificados
                        </p>
                    </div>
                </div>

                <!-- DIFERENCIAL 2 -->

                <div style="display: flex; gap: 20px;">
                    <div style="flex-shrink: 0; width: 56px; height: 56px; background: linear-gradient(135deg, var(--success), #388e3c); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        💰
                    </div>
                    <div>
                        <h3 style="font-size: 20px; margin-bottom: 8px;">Preços Competitivos</h3>
                        <p style="color: var(--text-secondary);">
                            Melhores preços do mercado com parcelamento sem juros
                        </p>
                    </div>
                </div>

                <!-- DIFERENCIAL 3 -->

                <div style="display: flex; gap: 20px;">
                    <div style="flex-shrink: 0; width: 56px; height: 56px; background: linear-gradient(135deg, var(--warning), #f57c00); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        🚀
                    </div>
                    <div>
                        <h3 style="font-size: 20px; margin-bottom: 8px;">Entrega Rápida</h3>
                        <p style="color: var(--text-secondary);">
                            Enviamos para todo o Brasil com prazos ágeis
                        </p>
                    </div>
                </div>

                <!-- DIFERENCIAL 4 -->

                <div style="display: flex; gap: 20px;">
                    <div style="flex-shrink: 0; width: 56px; height: 56px; background: linear-gradient(135deg, var(--info), #1565c0); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        🎧
                    </div>
                    <div>
                        <h3 style="font-size: 20px; margin-bottom: 8px;">Suporte Especializado</h3>
                        <p style="color: var(--text-secondary);">
                            Equipe pronta para tirar suas dúvidas e ajudar
                        </p>
                    </div>
                </div>

                <!-- DIFERENCIAL 5 -->

                <div style="display: flex; gap: 20px;">
                    <div style="flex-shrink: 0; width: 56px; height: 56px; background: linear-gradient(135deg, var(--secondary), #c51162); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        🛡️
                    </div>
                    <div>
                        <h3 style="font-size: 20px; margin-bottom: 8px;">Garantia Estendida</h3>
                        <p style="color: var(--text-secondary);">
                            Todos os produtos com garantia do fabricante
                        </p>
                    </div>
                </div>

                <!-- DIFERENCIAL 6 -->

                <div style="display: flex; gap: 20px;">
                    <div style="flex-shrink: 0; width: 56px; height: 56px; background: linear-gradient(135deg, #9c27b0, #7b1fa2); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        💳
                    </div>
                    <div>
                        <h3 style="font-size: 20px; margin-bottom: 8px;">Pagamento Seguro</h3>
                        <p style="color: var(--text-secondary);">
                            Várias formas de pagamento com total segurança
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ======================================== -->
    <!-- SEÇÃO: CALL TO ACTION -->
    <!-- ======================================== -->
    <!-- Card com gradiente e CTA (Call To Action) -->
    <div class="card" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; text-align: center;">
        <div class="card-content" style="padding: 64px 32px;">
            

            <h2 style="font-size: 36px; margin-bottom: 16px; color: white;">
                Pronto para começar?
            </h2>
            
            <p style="font-size: 18px; margin-bottom: 32px; opacity: 0.9;">
                Descubra nossa linha completa de produtos gamer
            </p>
            
            <!-- BOTÕES DE AÇÃO -->

            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                
                <!-- BOTÃO: VER PRODUTOS -->
                <a href="index.php" class="btn" style="background: white; color: var(--primary); padding: 16px 32px; font-size: 16px;">
                    Ver Produtos
                </a>
                
                <!-- BOTÃO: FALAR CONOSCO -->
                <a href="contato.php" class="btn" style="background: transparent; border: 2px solid white; color: white; padding: 16px 32px; font-size: 16px;">
                    Falar Conosco
                </a>
            </div>
        </div>
    </div>

</div>


<?php
// INCLUI O RODAPÉ
require 'footer.php';
?>

<!-- ============================================ -->
<!-- CONCEITOS USADOS NESTA PÁGINA: -->
<!-- ============================================ -->
<!--
1. PÁGINA ESTÁTICA
   - Não tem lógica PHP complexa
   - Apenas HTML e CSS
   - Conteúdo informativo

2. GRID LAYOUTS
   - grid-3: 3 colunas iguais
   - grid-2: 2 colunas iguais
   - display: grid com gap

3. INLINE STYLES
   - Estilos CSS direto no HTML
   - Usado para estilos únicos desta página
   - Não afeta outras páginas

4. GRADIENTES
   - linear-gradient(): cria transições de cor
   - 135deg: direção diagonal
   - Usado nos ícones e CTA

5. FLEXBOX
   - display: flex
   - Alinha ícone + texto lado a lado
   - flex-shrink: 0 (ícone não diminui)
-->