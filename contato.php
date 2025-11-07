<?php
require 'header.php';

$mensagem_enviada = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aqui você implementaria o envio real de email
    // Por enquanto, apenas simula o envio
    $mensagem_enviada = true;
}
?>

<div class="container">
    
    <div class="breadcrumb">
        <a href="index.php">Início</a>
        <span>→</span>
        <span>Contato</span>
    </div>

    <div class="page-header">
        <h1>Entre em Contato 💬</h1>
        <p>Estamos aqui para ajudar você. Escolha a melhor forma de contato</p>
    </div>

    <?php if ($mensagem_enviada): ?>
        <div class="alert alert-success" style="max-width: 600px; margin: 0 auto 32px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <div>
                <strong>Mensagem enviada com sucesso!</strong><br>
                Entraremos em contato em breve. Obrigado!
            </div>
        </div>
    <?php endif; ?>

    <!-- INFORMAÇÕES DE CONTATO -->
    <div class="grid grid-4" style="margin-bottom: 48px;">
        <div class="card">
            <div class="card-content" style="text-align: center;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #e3f2fd, var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <h3 style="margin-bottom: 12px;">Telefone</h3>
                <p style="color: var(--text-secondary); margin-bottom: 8px; font-size: 15px;">(11) 99999-9999</p>
                <p style="color: var(--text-secondary); font-size: 13px;">Seg-Sex: 9h às 18h</p>
            </div>
        </div>

        <div class="card">
            <div class="card-content" style="text-align: center;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #f3e5f5, #ce93d8); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#9c27b0" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <h3 style="margin-bottom: 12px;">Email</h3>
                <p style="color: var(--text-secondary); margin-bottom: 4px; font-size: 14px;">contato@techstore.com</p>
                <p style="color: var(--text-secondary); font-size: 14px;">suporte@techstore.com</p>
            </div>
        </div>

        <div class="card">
            <div class="card-content" style="text-align: center;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #e8f5e9, #81c784); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <h3 style="margin-bottom: 12px;">Endereço</h3>
                <p style="color: var(--text-secondary); font-size: 14px;">Rua Exemplo, 123<br>Centro - São Paulo/SP<br>CEP: 01234-567</p>
            </div>
        </div>

        <div class="card">
            <div class="card-content" style="text-align: center;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #fff3e0, #ffb74d); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--warning)" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h3 style="margin-bottom: 12px;">Horário</h3>
                <p style="color: var(--text-secondary); margin-bottom: 4px; font-size: 14px;">Seg-Sex: 9h às 18h</p>
                <p style="color: var(--text-secondary); margin-bottom: 4px; font-size: 14px;">Sábado: 9h às 13h</p>
                <p style="color: var(--text-secondary); font-size: 14px;">Domingo: Fechado</p>
            </div>
        </div>
    </div>

    <!-- FORMULÁRIO E MAPA -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 48px;">
        
        <!-- FORMULÁRIO -->
        <div class="card">
            <div class="card-content">
                <h2 style="margin-bottom: 8px;">Envie uma Mensagem</h2>
                <p style="color: var(--text-secondary); margin-bottom: 32px;">
                    Preencha o formulário e retornaremos em breve
                </p>

                <form method="POST" action="">
                    <div class="form-group">
                        <label class="form-label">👤 Seu Nome *</label>
                        <input type="text" name="nome" class="form-input" placeholder="João da Silva" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">📧 Seu Email *</label>
                        <input type="email" name="email" class="form-input" placeholder="seu@email.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">📱 Telefone</label>
                        <input type="tel" name="telefone" class="form-input" placeholder="(11) 99999-9999">
                    </div>

                    <div class="form-group">
                        <label class="form-label">💬 Assunto *</label>
                        <select name="assunto" class="form-select" required>
                            <option value="">Selecione um assunto</option>
                            <option value="duvida">Dúvida sobre produto</option>
                            <option value="pedido">Status do pedido</option>
                            <option value="troca">Troca ou devolução</option>
                            <option value="sugestao">Sugestão</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">✍️ Mensagem *</label>
                        <textarea name="mensagem" class="form-textarea" rows="5" placeholder="Digite sua mensagem..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Enviar Mensagem
                    </button>
                </form>
            </div>
        </div>

        <!-- MAPA E REDES SOCIAIS -->
        <div>
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-content">
                    <h2 style="margin-bottom: 20px;">Nossa Localização</h2>
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #e3f2fd 0%, #90caf9 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 48px;">
                        📍
                    </div>
                    <p style="text-align: center; margin-top: 16px; color: var(--text-secondary);">
                        Rua Exemplo, 123 - Centro<br>
                        São Paulo/SP - CEP: 01234-567
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h2 style="margin-bottom: 20px;">Nossas Redes Sociais</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 16px; background: var(--background); border-radius: 8px; text-decoration: none; color: var(--text-primary); transition: var(--transition);" onmouseover="this.style.background='var(--primary)'; this.style.color='white';" onmouseout="this.style.background='var(--background)'; this.style.color='var(--text-primary)';">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                            </svg>
                            Facebook
                        </a>

                        <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 16px; background: var(--background); border-radius: 8px; text-decoration: none; color: var(--text-primary); transition: var(--transition);" onmouseover="this.style.background='#E4405F'; this.style.color='white';" onmouseout="this.style.background='var(--background)'; this.style.color='var(--text-primary)';">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5"/>
                                <circle cx="12" cy="12" r="4"/>
                                <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
                            </svg>
                            Instagram
                        </a>

                        <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 16px; background: var(--background); border-radius: 8px; text-decoration: none; color: var(--text-primary); transition: var(--transition);" onmouseover="this.style.background='#1DA1F2'; this.style.color='white';" onmouseout="this.style.background='var(--background)'; this.style.color='var(--text-primary)';">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>
                            </svg>
                            Twitter
                        </a>

                        <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 16px; background: var(--background); border-radius: 8px; text-decoration: none; color: var(--text-primary); transition: var(--transition);" onmouseover="this.style.background='#FF0000'; this.style.color='white';" onmouseout="this.style.background='var(--background)'; this.style.color='var(--text-primary)';">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/>
                                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="#1a237e"/>
                            </svg>
                            YouTube
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- FAQ RÁPIDO -->
    <div class="card">
        <div class="card-content">
            <h2 style="text-align: center; margin-bottom: 32px;">Perguntas Frequentes</h2>
            <div class="grid grid-2" style="gap: 32px;">
                <div>
                    <h3 style="margin-bottom: 12px; display: flex; align-items: center; gap: 12px;">
                        <span style="color: var(--primary);">❓</span>
                        Qual o prazo de entrega?
                    </h3>
                    <p style="color: var(--text-secondary); line-height: 1.8;">
                        O prazo varia de acordo com sua região. Normalmente de 3 a 10 dias úteis para todo o Brasil.
                    </p>
                </div>

                <div>
                    <h3 style="margin-bottom: 12px; display: flex; align-items: center; gap: 12px;">
                        <span style="color: var(--primary);">❓</span>
                        Posso trocar ou devolver?
                    </h3>
                    <p style="color: var(--text-secondary); line-height: 1.8;">
                        Sim! Você tem 7 dias para trocar ou devolver qualquer produto, conforme o Código de Defesa do Consumidor.
                    </p>
                </div>

                <div>
                    <h3 style="margin-bottom: 12px; display: flex; align-items: center; gap: 12px;">
                        <span style="color: var(--primary);">❓</span>
                        Os produtos têm garantia?
                    </h3>
                    <p style="color: var(--text-secondary); line-height: 1.8;">
                        Todos os produtos possuem garantia do fabricante, com prazos que variam de 3 meses a 2 anos.
                    </p>
                </div>

                <div>
                    <h3 style="margin-bottom: 12px; display: flex; align-items: center; gap: 12px;">
                        <span style="color: var(--primary);">❓</span>
                        Quais formas de pagamento?
                    </h3>
                    <p style="color: var(--text-secondary); line-height: 1.8;">
                        Aceitamos cartão de crédito (parcelado em até 12x), PIX e boleto bancário.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require 'footer.php'; ?>