<div class="row">
    <div class="col-sm-12">
        <h3 class="text-center">Lista de Leads</h3>

        <!-- Barra de Pesquisa -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar por nome ou e-mail" onkeyup="filterLeads()">
        </div>

        <!-- Contêiner com rolagem para a tabela -->
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd;">
            <table class="table table-striped table-hover" id="leadsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data de Criação</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Tipo</th> <!-- Nova Coluna -->
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($leads)): ?>
                        <?php foreach ($leads as $lead): ?>
                            <tr>
                                <td><?= htmlspecialchars($lead['id']) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($lead['created_at']))) ?></td>
                                <td><?= htmlspecialchars($lead['nome']) ?></td>
                                <td><?= htmlspecialchars($lead['fone']) ?></td>
                                <td><?= htmlspecialchars($lead['email']) ?></td>
                                <!-- Exibição Condicional do Tipo -->
                                <td><?= ($lead['tipo'] != "") ? $lead['tipo'] : 'Gratuito' ?></td>
                                <td>
                                    <!-- Ícone para promover -->
                                    <i class="fa fa-user-graduate text-success mx-2"
                                        style="cursor: pointer;"
                                        title="Promover para Aluno"
                                        onclick="openPromoteModal(<?= htmlspecialchars(json_encode($lead)) ?>)"></i>

                                    <!-- Ícone para enviar notificação -->
                                    <i class="fa fa-paper-plane text-primary mx-2" style="cursor: pointer;"
                                        title="Enviar Notificação"
                                        data-id="<?= $lead['id'] ?>"
                                        data-nome="<?= htmlspecialchars($lead['nome']) ?>"
                                        data-email="<?= htmlspecialchars($lead['email']) ?>"
                                        data-fone="<?= htmlspecialchars($lead['fone']) ?>"
                                        onclick="openNotificationModal(this)"></i>
                                </td>
                                <!-- Colunas Ocultas -->
                                <td style="display: none;" class="lead-access"><?= htmlspecialchars($lead['acesso']) ?></td>
                                <td style="display: none;" class="lead-dados"><?= htmlspecialchars($lead['dados'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum lead cadastrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="notificationForm" method="POST" action="app/functions/push/lead-notifica.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Enviar Notificação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="notifLeadId" name="notif_id">
                    <div class="mb-3">
                        <label for="notifLeadName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="notifLeadName" name="notif_nome" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="notifLeadPhone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="notifLeadPhone" name="notif_fone" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="notifLeadEmail" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="notifLeadEmail" name="notif_email" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="notifMessage" class="form-label">Mensagem</label>
                        <textarea
                            class="form-control"
                            id="notifMessage"
                            name="notif_message"
                            rows="4"
                            placeholder="Escreva sua notificação aqui..."
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="promoteModal" tabindex="-1" aria-labelledby="promoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="promoteModalLabel">Gerenciar Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="promoteForm" method="POST" action="app/functions/push/user-lead.php">
                    <input type="hidden" id="leadId" name="id">
                    <input type="hidden" id="action" name="action" value="update"> <!-- Valor padrão -->
                    <div class="mb-3">
                        <label for="leadName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="leadName" name="nome" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="leadEmail" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="leadEmail" name="email" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="leadPhone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="leadPhone" name="fone" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="leadAccess" class="form-label">Acesso</label>
                        <input type="text" class="form-control" id="leadAccess" name="acesso" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="leadType" class="form-label">Tipo</label>
                        <select class="form-control" id="leadType" name="tipo">
                            <option value="Gratuito">Gratuito</option>
                            <option value="Aluno">Aluno</option>
                            <option value="Degusta">Degusta</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="leadDados" class="form-label">Dados Complementares</label>
                        <textarea class="form-control" id="leadDados" name="dados" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary" data-action="update">Atualizar</button>
                        <button type="submit" class="btn btn-warning" data-action="sendPassword">Enviar Senha</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<script>
    // Filtrar leads em tempo real
    function filterLeads() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#leadsTable tbody tr');

        rows.forEach(row => {
            const name = row.cells[2].textContent.toLowerCase();
            const email = row.cells[4].textContent.toLowerCase();
            row.style.display = (name.includes(input) || email.includes(input)) ? '' : 'none';
        });
    }


    function openPromoteModal(lead) {
        // Preencher os campos do modal com os dados do lead
        document.getElementById('leadId').value = lead.id;
        document.getElementById('leadName').value = lead.nome;
        document.getElementById('leadEmail').value = lead.email;
        document.getElementById('leadDados').value = lead.dados || ''; // Dados complementares
        document.getElementById('leadAccess').value = lead.acesso;

        // Abrir o modal
        const promoteModal = new bootstrap.Modal(document.getElementById('promoteModal'));
        promoteModal.show();
    }

    function openNotificationModal(element) {
    // Preenche os campos do modal com os dados do lead
    document.getElementById('notifLeadId').value = element.getAttribute('data-id');
    document.getElementById('notifLeadName').value = element.getAttribute('data-nome');
    document.getElementById('notifLeadPhone').value = element.getAttribute('data-fone');
    document.getElementById('notifLeadEmail').value = element.getAttribute('data-email');

    // Abre o modal
    const notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
    notificationModal.show();
}
</script>